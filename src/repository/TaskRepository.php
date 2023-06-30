<?php 
require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../model/Task.php';

function persistTask ($task): void {
  global $pdo;
  if ($task->getId()) {
    $stmt = $pdo->prepare('UPDATE tasks SET title = :title, description = :description, concluida = :concluida, file = :file WHERE id = :id');
    $stmt->execute([
      ':id' => $task->getId(),
      ':title' => $task->getTitle(),
      ':description' => $task->getDescription(),
      ':concluida' => $task->isConcluida() ? '1' : '0',
      ':file' => $task->getFile()
    ]);
  } else {
    $stmt = $pdo->prepare("INSERT INTO tasks (title, description, concluida, file) VALUES (:title, :description, :concluida, :file)");
    $stmt->bindValue(':title', $task->getTitle());
    $stmt->bindValue(':description', $task->getDescription());
    $stmt->bindValue(':concluida', $task->isConcluida(), PDO::PARAM_BOOL);
    $stmt->bindValue(':file', $task->getFile());
    $stmt->execute();

    $task->setId($pdo->lastInsertId());
  }

}

function getAllTasks (): array {
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

function getTaskById($id) {
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

function deleteTask($id) {
  global $pdo;
  $stmt = $pdo->prepare('DELETE FROM tasks WHERE id = :id');
  $stmt->execute(['id' => $id]);
  if ($stmt->rowCount() > 0) {
    return true;
  } else {
    return false;
  }
}



?>