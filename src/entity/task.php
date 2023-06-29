<?php

require_once __DIR__ . '/../../db.php';

class Task {
  private ?int $id;
  private ?string $title;
  private ?string $description;
  private bool $concluida;
  private ?string $file;

  public function __construct(?int $id, ?string $title, ?string $description, bool $concluida, ?string $file) {
    $this->id = $id;
    $this->title = $title;
    $this->description = $description;
    $this->concluida= $concluida;
    $this->file = $file;
  }

  public function getId (): int {
    return $this->id;
  }

  public function setId (int $id): void {
    $this->id = $id;
  }

  public function getTitle (): string {
    return $this->title;
  }

  public function setTitle (string $title): void {
    $this->title = $title;
  }

  public function getDescription (): string {
    return $this->description;
  }

  public function setDescription (string $description): void {
    $this->description = $description;
  }

  public function isConcluida (): bool {
    return $this->concluida;
  }

  public function setConcluida (bool $concluida): void {
    $this->concluida = $concluida;
  }

  public function getFile (): ?string {
    return $this->file;
  }

  public function setFile (string $file): void {
    $this->file = $file;
  }

  public function persistTask (): void {
    global $pdo;
    if ($this->id) {
      $stmt = $pdo->prepare('UPDATE tasks SET title = :title, description = :description, concluida = :concluida, file = :file WHERE id = :id');
      $stmt->execute([
        ':id' => $this->id,
        ':title' => $this->title,
        ':description' => $this->description,
        ':concluida' => $this->concluida ? '1' : '0',
        ':file' => $this->file
      ]);
    } else {
      $stmt = $pdo->prepare("INSERT INTO tasks (title, description, concluida, file) VALUES (:title, :description, :concluida, :file)");
      $stmt->bindValue(':title', $this->getTitle());
      $stmt->bindValue(':description', $this->getDescription());
      $stmt->bindValue(':concluida', $this->isConcluida(), PDO::PARAM_BOOL);
      $stmt->bindValue(':file', $this->getFile());
      $stmt->execute();
  
      $this->setId($pdo->lastInsertId());
    }

  }

  public static function getAllTasks (): array {
    global $pdo;

    $stmt = $pdo->query("SELECT * FROM tasks");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $tasks = [];

    foreach ($results as $result) {
      $task = new Task(
        $result['id'],
        $result['title'],
        $result['description'],
        (bool) $result['concluida'],
        $result['file']
      );

      $tasks[] = $task;
    }

    return $tasks;
  }

  public static function getTaskById($id) {
    global $pdo;
    $stmt = $pdo->prepare('SELECT * FROM tasks WHERE id = :id');
    $stmt->execute([':id' => $id]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
      if ($result) {
        return new Task(
          $result['id'],
          $result['title'],
          $result['description'],
          (bool) $result['concluida'],
          $result['file']
        );
      } else {
        return null;
      }
  }

  public static function deleteTask($id) {
    global $pdo;
    $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
    $stmt->execute(['id' => $id]);
    if ($stmt->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }
}


?>