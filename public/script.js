function openTask(taskId) {
  formOpen = false;
  document.addEventListener('click', function(event) {
  const openTaskDiv = document.getElementById('open-task');
  const isClickInsideOpenTask = openTaskDiv.contains(event.target);

  if (!isClickInsideOpenTask) {
    openTaskDiv.classList.remove('open');
  }
  });
    fetch('/public/components/view-task.php?id=' + taskId)
      .then(response => response.text())
      .then(data => {
        document.getElementById('open-task').innerHTML = data;
        document.getElementById('open-task').classList.add('open');
      })
      .catch(error => console.error(error));
  }

  function deleteTask(taskId) {
    fetch('/src/deleteTask.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: 'task_id=' + taskId,
    })
      .then(response => response.text())
      .then(data => {
        if (data === 'OK') {
          console.log('Tarefa excluída com sucesso!');
          const taskDiv = document.getElementById('div' + taskId);
           if (taskDiv) {
          taskDiv.style.display = 'none';
           }
        } else {
          console.log('Erro ao excluir a tarefa!');
        }
      })
      .catch(error => console.error(error));
}

function closeTask () {
  const openTaskDiv = document.getElementById('open-task');
  openTaskDiv.classList.remove('open');
  
}  

let formOpen = false;

function toggleForm() {
  let addTaskInput = document.getElementById('addTask');
  let formContainer = document.getElementById('formContainer');
  if (!formOpen) {
    fetch('/src/forms/FormTask.html')
      .then(response => response.text())
      .then(data => {
        formContainer.innerHTML = data;
        addTaskInput.style.display = 'none';
        formOpen = true;
        document.getElementById('title').focus();
      })
      .catch(error => console.error(error));
      document.addEventListener('click', function(event) {
        const isClickInsideOpenTask = formContainer.contains(event.target); 
        if (!isClickInsideOpenTask) {
          formContainer.innerHTML = '';
           addTaskInput.style.display = 'block';
         formOpen = false;
        }
        })
    
  } else {
    formContainer.innerHTML = '';
    addTaskInput.style.display = 'block';
    formOpen = false;
  }
}


function updateTask(taskId, field, value) {
  console.log(taskId, field, value)
  if (field === 'description') {
    value = value.replace(/\n/g, '<br>');
  }
  let xhr = new XMLHttpRequest();
  xhr.open('POST', '/src/updateTask.php');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.onload = function() {
    if (xhr.status === 200 && xhr.responseText === 'OK') {
      console.log('Status de conclusão da tarefa atualizado com sucesso!');
    } else {
      console.log('Erro ao atualizar o status de conclusão da tarefa!');
    }
  };
  xhr.send('task_id=' + taskId + '&field=' + field + '&value=' + encodeURIComponent(value));

}

function updateFile(taskId, file) {
  const formData = new FormData();
  formData.append('task_id', taskId);
  formData.append('field', 'file');
  formData.append('file', file);

  const xhr = new XMLHttpRequest();
  xhr.open('POST', '/src/updateTask.php');
  xhr.onload = function() {
    if (xhr.status === 200 ) {
      const safeName = xhr.responseText.replace('OK', '');
      if (safeName) {
        console.log(safeName)
        const fileUrl = '../../src/files-uploaded/' + safeName; 
        let fileLink = document.createElement('a');
        console.log(fileLink)
        fileLink.href = fileUrl;
        fileLink.id = 'fileView'
        fileLink.target = '_blank';
        fileLink.textContent = 'Arquivo: ' + safeName;
        document.getElementById('fileDisplay'+taskId).appendChild(fileLink);
      console.log('Arquivo da tarefa atualizado com sucesso!');
     } else {
      console.log('Não foi retornado um nome de arquivo seguro.');
     }
    } else {
      console.log('Erro ao atualizar o arquivo da tarefa!');
    }
  };
  xhr.send(formData);
}


function editTask(taskId) {
  
  let titleDisplay = document.getElementById('title');
  let titleElem = document.getElementById('titleView' + taskId);
  let title = titleElem.innerText;  

  let descriptionDisplay = document.getElementById('description');
  let descriptionElem = document.getElementById('descriptionView' + taskId);
  let description = descriptionElem.innerText;
  descriptionElem.parentNode.style = 'background-color: #C1D9E3';
  
  let inputTitle = document.createElement('input');
  inputTitle.type = 'text';
  inputTitle.value = title;
  inputTitle.required = true;
  titleDisplay.replaceChild(inputTitle, titleElem);

  let inputDescription = document.createElement('textarea');
  inputDescription.value = description;
  descriptionDisplay.replaceChild(inputDescription, descriptionElem);

  let fileDisplay = document.getElementById('fileDisplay' + taskId);
  let deleteFile = document.createElement('button');
  deleteFile.id = 'deleteFile';
  deleteFile.type = 'button';
  deleteFile.innerText = 'Excluir arquivo';
  deleteFile.onclick = function(event) {
    event.stopPropagation()
    updateTask(taskId, 'file', '');
    fileDisplay.removeChild(document.getElementById('fileView'));
    fileDisplay.removeChild(deleteFile);
    fileDisplay.appendChild(createFile);  
  }

  let createFile = document.createElement('input');
  createFile.type="file"
  createFile.id="fileInput"
  createFile.title="Subir Arquivo"
  createFile.name="file"
  createFile.accept=".jpg, .jpeg, .png"
  createFile.onchange="checkFileSize(this)"
  let newFile = false;
  createFile.onchange = function() {
    console.log(taskId, 'file', this.files[0].name);
    newFile = true;
  }

  if (fileDisplay.innerText) {
    fileDisplay.appendChild(deleteFile);
  } else {
    fileDisplay.appendChild(createFile);
  }
  
  let buttonDisplay = document.getElementById('buttonDisplay');
  let editButton = document.getElementById('editButton');
  let finishButton = document.createElement('button');
  finishButton.id = 'finishButton';
  finishButton.type = 'button';
  finishButton.innerText = 'Concluir';
  
  buttonDisplay.appendChild(finishButton); 
  editButton.style.display = 'none';
  
  finishButton.onclick = function(event) {
    event.stopPropagation()
    updateTask(taskId, 'title', inputTitle.value);
    updateTask(taskId, 'description', inputDescription.value);
    if (newFile) {
      console.log(taskId, createFile.files[0]);
      updateFile(taskId, createFile.files[0]);
    }
   
    titleDisplay.replaceChild(titleElem, inputTitle);
    descriptionDisplay.replaceChild(descriptionElem, inputDescription);
    editButton.style.display = 'block'; 

    buttonDisplay.removeChild(finishButton);
    fileDisplay.removeChild(createFile);
    fileDisplay.removeChild(deleteFile);
   
    document.getElementById('descriptionView' + taskId).innerText = inputDescription.value;
    document.getElementById('titleView' + taskId).innerText = inputTitle.value;
    document.getElementById('descriptionMain' + taskId).innerText = inputDescription.value.replace(/\n/g, ' ').replace('<br>', ' ').substring(0, 20) + '...';
    document.getElementById('titleMain' + taskId).innerText = inputTitle.value;

  }
}

function updateTaskStyle(taskId, isConcluida) {
    const taskElem = document.getElementById('text' + taskId);
    const taskElem2 = document.getElementById('titleView' + taskId);
    let checkElem = document.getElementById('check' + taskId);
    let divElem = document.getElementById('div' + taskId);

    console.log(checkElem)

    divElem.style.backgroundColor = isConcluida ? '#B8B5AD' : 'white';
    taskElem.style.textDecoration = isConcluida ? 'line-through' : 'none';
    taskElem2.style.textDecoration = isConcluida ? 'line-through' : 'none';
    checkElem.checked = isConcluida;
  }
function checkFileSize(input) {
    const file = input.files[0];
    const maxSize = 20 * 1024 * 1024; // 20 Mb em bytes

    if (file && file.size > maxSize) {
      alert('O tamanho do arquivo excede o limite de 20 Mb.');
      input.value = ''; // Limpa o valor do input para permitir selecionar outro arquivo
    }
  }