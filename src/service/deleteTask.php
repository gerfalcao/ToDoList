<?php

require_once '../model/Task.php';
require_once '../repository/TaskRepository.php';

$taskId = $_POST['task_id'];

$success = deleteTask($taskId);

if ($success) {
  echo 'OK';
} else {
  echo 'Erro ao excluir a tarefa';
}

?>