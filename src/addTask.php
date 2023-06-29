<?php
require_once '../db.php';
require_once './entity/task.php';

var_dump($_POST);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $fileInfo = $_FILES['file'];
        $fileName = $fileInfo['name'];
        $hash = uniqid();
        $safeName = $hash . '_' . $fileName;

        
        move_uploaded_file($fileInfo['tmp_name'], './files-uploaded/' . $safeName);

        // Task com arquivo
        $task = new Task(null, $_POST['title'], $_POST['title'], $_POST['description'], 0, $fileName);
        $task->setFile($safeName);
    } else {
        // Task sem arquivo
        $task = new Task(null, $_POST['title'], $_POST['title'], $_POST['description'], 0, null);
    }   

    if (!empty($_POST['title'])) {
      $task->setTitle($_POST['title']);
    } else {
      $task->setTitle('Nova tarefa'); 
    }

    if (!empty($_POST['description'])) {
    $task->setDescription($_POST['description']);
    } else {
    $task->setDescription(' '); 
    }
    $task->setConcluida(false);
    $task->persistTask();

    header('Location: /'); // Redireciona de volta para a página inicial
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    header('Location: /');
}
?>
