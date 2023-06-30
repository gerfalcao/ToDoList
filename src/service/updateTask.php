<?php
require_once '../../config/db.php';
require_once '../model/Task.php';
require_once '../repository/TaskRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $taskId = $_POST['task_id'];
  $field = $_POST['field'];
  $value = $_POST['value'];
  $file = $_FILES['file'];

  $task = getTaskById($taskId);
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
    persistTask($task);
    echo 'OK';
  } else {
    echo 'Tarefa não encontrada';
  }
  
}
?>