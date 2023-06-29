<?php 

require_once '../../src/entity/task.php';

$task = Task::getTaskById($_GET['id']);

echo '
  <div>
    <div class="view-task-title" id="title">
      <h1 id="titleView' . $task->getId() . '" style="'; echo $task->isConcluida() ? 'text-decoration: line-through' : ''; 
      echo '">' 
        . $task->getTitle() .
      '</h1>
    </div>
    <div class="view-task-description" id="description">
      <p id="descriptionView' . $task->getId() . '">'
        . $task->getDescription() .
        '</p>
      
    </div>
    <div class="file-display" id="fileDisplay' . $task->getId() . '">';
    if ($task->getFile() !== 'null' && $task->getFile() !== '' && $task->getFile() !== '0') {
      $fileUrl = '../../src/files-uploaded/' . $task->getFile();
      echo "<a href='{$fileUrl}' target='_blank' id='fileView'>Arquivo: {$task->getFile()}</a>";
    };
    echo '</div>
    <div class="view-task-buttons">
      
      <div id="buttonDisplay">
        <div id="editButton">
          <button id="editButton" onclick="editTask(' . $task->getId() . ')">Editar</button>
          <button id="concluirButton" onclick="updateTask(' . $task->getId() . ', \'concluida\', ' . ($task->isConcluida() ? 'false' : 'true') . ');updateTaskStyle(' . $task->getId() . ',' . ($task->isConcluida() ? 'false' : 'true') . ');">Concluir tarefa</button>
        </div>
      </div>
      <button id="deleteButton" onclick="deleteTask(' . $task->getId() . '); closeTask()">Deletar</button>
    </div>
    
   
  </div>
'
?>