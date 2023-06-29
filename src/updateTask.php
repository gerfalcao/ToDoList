<?php
require_once '../db.php';
require_once './entity/task.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $taskId = $_POST['task_id'];
  $field = $_POST['field'];
  $value = $_POST['value'];
  $file = $_FILES['file'];

  $task = Task::getTaskById($taskId);
  if ($task) {
    switch ($field) {
      case 'title':
        $task->setTitle($value);
        break;
      case 'description':
        $task->setDescription($value);
        break;
      case 'concluida':
        if ($value === 'true') {
          $task->setConcluida(1);
        } else {
          $task->setConcluida(0);
        }
        // $task->setConcluida($value);
        break;
      case 'file':
        if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
          $fileInfo = $_FILES['file'];
          $fileName = $fileInfo['name'];
          $hash = uniqid();
          $safeName = $hash . '_' . $fileName;
          echo $safeName;
          
          move_uploaded_file($fileInfo['tmp_name'], './files-uploaded/' . $safeName);
          $task->setFile($safeName);
        } else {
          $task->setFile('null');
        };
        break;
      default:
        echo 'Campo inválido';
        exit;
    }
    $task->persistTask();
    echo 'OK';
  } else {
    echo 'Tarefa não encontrada';
  }
  
  // $taskId = $_POST['task_id'];
  // $concluida = $_POST['concluida'] === '1';

  // $stmt = $pdo->prepare("UPDATE tasks SET concluida = :concluida WHERE id = :id");
  // $stmt->bindValue(':concluida', $concluida, PDO::PARAM_BOOL);
  // $stmt->bindValue(':id', $taskId, PDO::PARAM_INT);
  // $stmt->execute();

  // if ($stmt->rowCount() === 1) {
  //   echo 'OK';
  // } else {
  //   echo 'Erro ao atualizar o status de conclusão da tarefa!';
  // }
}
?>