/*

  === API modifiers ===
  - addTask()
  - completeTask()
  - deleteTask()
  - getTasks() - plural
  - getTask() - singluar
  - storeTasksOrder()

  === DOM modifers ===
  - renderTask()
  - toggleTaskDetails() - currently not in use
  - getTaskData()
  - findTaskId()
  - setTaskData()
  - editTask() - Trigger edit mode
  - editTaskCallback()
  - deleteTaskCallback()

*/

// Create new task
function addTask(form, callback = null){
  app.log("Add task");
  app.log(form);

  submitForm(form,function(data){
    if(typeof callback == 'function') callback(data);
  });

}

function completeTask(task_id, status,callback=null){
  app.log("Complete task "+task_id+" with "+status);

  apiPost({'_action':'complete_task','task_id':task_id,'is_completed':status}, function(data){
    app.log("Task completed");
    if(typeof callback == 'function') callback(data);
  });
}

// Delete task
function deleteTask(task_id, callback = null){
  app.log("Preparing to delete task with id "+task_id);

  if(confirm("Vill du ta bort uppgiften?")){
    apiPost({"_action":"delete_task","task_id" : task_id}, function(data){
      app.log("Task deleted");
      if(typeof callback == 'function') callback(data);
    });
  } else{
    app.log("Task not deleted.");
  }
}

// Function to be called after a task has been deleted
function deleteTaskCallback(data){
  let currentURL = window.location.href;
  app.log(currentURL);

  let parts = currentURL.split("/tasks");

  //Redirect URL
  if(parts.length > 1)  location.href = parts[0];

  //Remove task from dom
  let taskElement = document.getElementById('task-'+data.task_id);
  if(taskElement) taskElement.remove();

}

// Get multiple tasks
function getTasks(list_id = null, get_subtasks = false, callback=null){
  app.log("Getting list tasks");

  apiPost({"_action":"GET_TASKS","list_id":list_id,"get_subtasks":get_subtasks}, function(data){
    app.log("Tasks retrieved");
    if(typeof callback == 'function') callback(data);
  });
}

// Get a signle tasks
function getTask(task_id, get_subtasks = false, callback=null){
  app.log("Getting task with id of "+task_id);
  
  apiPost({"_action":"GET_TASK","task_id":task_id,"get_subtasks":get_subtasks}, function(data){
    app.log("Task retrieved");
    if(typeof callback == 'function') callback(data);
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
    let desc = taskElement.querySelector(".js-task-description");
    if(desc) desc.innerHTML = data.description;
    
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
  if(parentElement){
    parentElement.append(taskElement);
  }
  
  taskElement = document.getElementById("task-"+data.id);
  if(callback !== null) callback(taskElement);
  
}

// Edit task
function editTask(task_id, callback = null){

  let editModal = document.getElementById('modal-task-update');

  // Get fresh data from database to ensure it's up to date
  getTask(task_id,true,function(data){
    editModal.querySelector("[name='title']").value = data.title;
    editModal.querySelector("[name='description']").value = data.description;
    editModal.querySelector("[name='task_id']").value = data.id;

    let wysiwyg = editModal.querySelector("trix-editor");
    trixRefresh(wysiwyg, data.description); 
    
  });

  openModal('modal-task-update');
}

// Function to be called after a task has been edited
function editTaskCallback(data){
  
  // Update changes in DOM
  let taskElement = document.getElementById('task-'+data.task_id);
  setTaskData(data,taskElement);

  closeModal("modal-task-update");  
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

  app.log(taskElement);

  if(!taskElement) return {};

  // Find task elements in DOM
  let title = taskElement.querySelector(".js-task-title");
  let description = taskElement.querySelector(".js-task-description");

  description = (description) ? description.innerHTML : "";
  title = (title) ? title.innerHTML : "";
  
  // Build dataset to return
  return {
    id: findTaskId(taskElement),
    title: title,
    description: description,

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

// Save the new order of the tasks within a list
// tasksOrder = comma separated string with task ids
function updateSortedTasks(tasksOrder, listId){
  app.log("Update tasks order in list");
  app.log(tasksOrder);

  let data = {
    _action: "update_tasks_order",
    tasks_order: tasksOrder,
    list_id: listId
  }
  
  apiPost(data,function(data){
    app.log("Tasks order updated");
    app.log(data);
  });

}