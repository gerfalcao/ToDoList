<?php

require_once 'src/repository/TaskRepository.php';

echo '
  <div class="list">  
  <h2>Lista de tarefas</h2>';
  $tasks = getAllTasks();
 
  foreach ($tasks as $task) {
    echo '
      <div class="item-task" id="div' . $task->getId() . '" onclick="openTask(' . $task->getId() . ')" style="background-color:'; echo $task->isConcluida() ? '#B8B5AD' : 'white'; echo '">
        <div>
          <input id="check' . $task->getId() . '" disabled type="checkbox" name="concluida" value="1" ' . ($task->isConcluida() ? 'checked' : '') . '>
        </div>
        <div id="text' . $task->getId() . '" style="display: flex; flex-wrap: nowrap; align-items: flex-end; justify-content: space-between; width: 100%;'; echo $task->isConcluida() ? 'text-decoration: line-through' : ''; echo '">
          <div class="task-title" 
               id="titleMain' . $task->getId() . '">'
               . $task->getTitle() 
               . '</div>
          <div class="resumo" id="descriptionMain' . $task->getId() . '">'
               . substr(str_replace('<br>', ' ', str_replace('%0A', ' ', $task->getDescription())), 0, 20) . 
          '</div>
        </div>
      </div>
    ';
  }
    echo '
      <div class="item-task">
         <input id="addTask" class="formTitle" type="text" onclick="toggleForm()" placeholder="Nova tarefa..." ><div id="formContainer"></div>
      </div>
    ';

    echo '
      <div id="open-task">
        <p>task</p>
      </div><div id="open-task-overlay"></div>
    ';

  
echo  '</div>
  ';

?>

<script>

// function openTask(taskId) {
//   formOpen = false;
//   document.addEventListener('click', function(event) {
//   const openTaskDiv = document.getElementById('open-task');
//   const isClickInsideOpenTask = openTaskDiv.contains(event.target);

//   if (!isClickInsideOpenTask) {
    
//     openTaskDiv.classList.remove('open');
//   }
//   });
//     fetch('/public/components/view-task.php?id=' + taskId)
//       .then(response => response.text())
//       .then(data => {
//         document.getElementById('open-task').innerHTML = data;
//         document.getElementById('open-task').classList.add('open');
//       })
//       .catch(error => console.error(error));
//   }

//   function deleteTask(taskId) {
//     fetch('/src/deleteTask.php', {
//       method: 'POST',
//       headers: {
//         'Content-Type': 'application/x-www-form-urlencoded',
//       },
//       body: 'task_id=' + taskId,
//     })
//       .then(response => response.text())
//       .then(data => {
//         if (data === 'OK') {
//           console.log('Tarefa excluída com sucesso!');
//           const taskDiv = document.getElementById('div' + taskId);
//            if (taskDiv) {
//           taskDiv.style.display = 'none';
//            }
//         } else {
//           console.log('Erro ao excluir a tarefa!');
//         }
//       })
//       .catch(error => console.error(error));
// }

// function closeTask () {
//   const openTaskDiv = document.getElementById('open-task');
//   openTaskDiv.classList.remove('open');
  
// }  

// let formOpen = false;

// function toggleForm() {
//   let addTaskInput = document.getElementById('addTask');
//   let formContainer = document.getElementById('formContainer');
//   if (!formOpen) {
//     fetch('/src/forms/FormTask.html')
//       .then(response => response.text())
//       .then(data => {
//         formContainer.innerHTML = data;
//         addTaskInput.style.display = 'none';
//         formOpen = true;
//       })
//       .catch(error => console.error(error));
//   } else {
//     formContainer.innerHTML = '';
//     addTaskInput.style.display = 'block';
//     formOpen = false;
//   }
// }


// function updateTask(taskId, field, value) {
//   console.log(value)
//   let xhr = new XMLHttpRequest();
//   xhr.open('POST', '/src/updateTask.php');
//   xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
//   xhr.onload = function() {
//     if (xhr.status === 200 && xhr.responseText === 'OK') {
//       console.log('Status de conclusão da tarefa atualizado com sucesso!');
//     } else {
//       console.log('Erro ao atualizar o status de conclusão da tarefa!');
//     }
//   };
//   xhr.send('task_id=' + taskId + '&field=' + field + '&value=' + encodeURIComponent(value));

// }


// function editTask(taskId) {
  
//   let titleDisplay = document.getElementById('title');
//   let titleElem = document.getElementById('titleView' + taskId);
//   let title = titleElem.innerText;  

//   let descriptionDisplay = document.getElementById('description');
//   let descriptionElem = document.getElementById('descriptionView' + taskId);
//   let description = descriptionElem.innerText;

//   let inputTitle = document.createElement('input');
//   inputTitle.type = 'text';
//   inputTitle.value = title;
//   inputTitle.required = true;
//   titleDisplay.replaceChild(inputTitle, titleElem);

//   let inputDescription = document.createElement('textarea');
//   inputDescription.value = description;
//   descriptionDisplay.replaceChild(inputDescription, descriptionElem);

//   let buttonDisplay = document.getElementById('buttonDisplay');
//   let editButton = document.getElementById('editButton');
//   let finishButton = document.createElement('button');
//   finishButton.id = 'finishButton';
//   finishButton.type = 'button';
//   finishButton.innerText = 'Concluir';
  
//   buttonDisplay.appendChild(finishButton); 
//   editButton.style.display = 'none';
  
//   finishButton.onclick = function() {
//     updateTask(taskId, 'title', inputTitle.value);
//     updateTask(taskId, 'description', inputDescription.value); 
//     titleDisplay.replaceChild(titleElem, inputTitle);
//     descriptionDisplay.replaceChild(descriptionElem, inputDescription);
//     editButton.style.display = 'block'; 
//     finishButton.style.display = 'none';
//     document.getElementById('descriptionView' + taskId).innerText = inputDescription.value;
//     document.getElementById('titleView' + taskId).innerText = inputTitle.value;
//     document.getElementById('descriptionMain' + taskId).innerText = inputDescription.value.substring(0, 20) + '...';
//     document.getElementById('titleMain' + taskId).innerText = inputTitle.value;

//   }
// }

// function updateTaskStyle(taskId, isConcluida) {
//     const taskElem = document.getElementById('text' + taskId);
//     taskElem.style.textDecoration = isConcluida ? 'line-through' : 'none';
//   }

</script>