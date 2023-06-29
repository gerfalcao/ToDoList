<?php

require_once './entity/task.php';

$taskId = $_POST['task_id'];

$success = Task::deleteTask($taskId);

if ($success) {
  echo 'OK';
} else {
  echo 'Erro ao excluir a tarefa';
}

?>