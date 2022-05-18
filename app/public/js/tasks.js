function completeTask(task_id, status,callback=null){
  app.log("Complete task "+task_id+" with "+status);

  apiRequest.send("patch", {'_action':'complete_task','task_id':task_id,'is_completed':status}, function(data){
    app.log("Task completed");
    if(callback !== null) callback(data);
  });
}

function deleteTask(task_id, callback = null){
  app.log("Deleting task");
  apiRequest.send("delete", {"_action":"delete_task","task_id" : task_id},  function(data){
    app.log("Task deleted");
    if(callback !== null) callback(data);
  });
}

function updateTask(task_id, callback = null){
  app.log("Updating task");
  apiRequest.send("patch", {"_action":"update_task","task_id" : task_id},  function(data){
    app.log("Task updated");
    if(callback !== null) callback(data);
  });
}


function getTasks(list_id = null, get_subtasks = false, callback=null){
  app.log("Getting list tasks");
  apiRequest.send("get", {"_action":"GET_TASKS","list_id":list_id,"get_subtasks":get_subtasks}, function(data){
    if(callback !== null) callback(data);
  });
}

function getTask(task_id, get_subtasks = false, callback=null){
  app.log("Getting task "+task_id);
  apiRequest.send("get", {"_action":"GET_TASK","task_id":task_id,"get_subtasks":get_subtasks}, function(data){
    if(callback !== null) callback(data);
  });
}


function setTaskData(data, taskElement){

  let taskTitle = taskElement.querySelector(".js-task-title");
  
  // Task id
  if(data.id) {
    // taskElement.setAttribute("data-id", data.id);
    if(taskTitle) taskTitle.href = "/tasks/"+data.id;
    taskWrapper = taskElement.querySelector(".js-task-wrapper");
    if(taskWrapper){
      taskWrapper.dataset.id = data.id;
      taskWrapper.id = "task-"+data.id;
    }else{
      taskElement.dataset.id = data.id;
      taskElement.id = "task-"+data.id;
    }
  }

  // Task title
  if(data.title && taskTitle) taskTitle.innerHTML = data.title;


  // Task description
  if(data.description) {
    let fullDesc = taskElement.querySelector(".js-task-description-full");
    if(fullDesc) fullDesc.innerHTML = data.description; 

    let shortDesc = taskElement.querySelector(".js-task-description-short");
    if(shortDesc) shortDesc.innerHTML = data.description.substring(0, 50)+"...";
  }

  // Checkbox
  if(data.is_completed){
    let checkbox      = taskElement.querySelector(".js-complete-task");
    if(checkbox){
      checkbox.checked  = (data.is_completed == 1) ? true : false;
      checkbox.id       = data.id;
    }
  }

  return taskElement;
}

// Render task to DOM
function renderTask(data, taskTemplate, parentElement, callback = null){
  app.log("Render task");
  app.log(data);
  
  let taskElement   = taskTemplate.content.cloneNode(true);
  taskElement = setTaskData(data, taskElement);
  
  // Append task to DOM
  parentElement.append(taskElement);
  taskElement = document.getElementById("task-"+data.id);
  
  if(callback !== null) callback(taskElement);
  
}

// Bind task events
function bindTaskEvents(taskElement, data = null){
  app.log("Bind task events");
  app.log(taskElement);

  // Checkbox
  let checkbox = taskElement.querySelector(".js-complete-task");
  if(checkbox){
    checkbox.addEventListener("change",function(){
      completeTask(checkbox.id, checkbox.checked, null);
    });
  }

  // Toggle details
  let detailsBtn = taskElement.querySelector(".js-toggle-details");
  if(detailsBtn){
    detailsBtn.addEventListener("click",function(){
      toggleTaskDetails(taskElement);
    });
  }

  // Delete task
  let deleteBtn = taskElement.querySelector(".js-delete-task");
  if(deleteBtn){
    deleteBtn.addEventListener("click", function(){
      if(confirm("Vill du ta bort denna uppgift?")){
        deleteTask(data.id, function(){
          taskElement.remove();
        });
      }
    });
  }

}

// Toggle task details
function toggleTaskDetails(taskElement){
  if(taskElement === null) {
    app.log("Unable to toggle task details - No task found");
    return false;
  }
  
  app.log("Toggle details for task");

  let lessDetails = taskElement.querySelector('.js-preview-details');
  let fullDetails = taskElement.querySelector('.js-fulldetails');
  let trigger     = taskElement.querySelector('.js-toggle-details');
  
  fullDetails.classList.toggle('hidden');
  lessDetails.classList.toggle('hidden');

  if(fullDetails.classList.contains('hidden')){
    trigger.innerHTML = "Visa mer";
  } else {
    trigger.innerHTML = "Visa mindre";
  }
}


// Get task data from DOM
function getTaskData(taskElement){
  return {
    id: findTaskId(taskElement),
  }
}

// Find task id in DOM
function findTaskId(taskElement){

  if(!taskElement) return null;

  let id = taskElement.dataset.id;
  if(id) return id
  
  taskElement = taskElement.querySelector(".js-task-wrapper");
  if(taskElement) id = taskElement.dataset.id;
  if(id) return id

  return null;

}
