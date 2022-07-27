// ==================
// Trigger: Add lists
// Trigger: Add tasks
// ==================
let listWrapper = document.getElementById('lists');
if(listWrapper){
  listWrapper.addEventListener("click",function(e){
    e.preventDefault();
    if(e.target.classList.contains('js-new-task-btn')){
      app.log("Button 'new task' clicked");
      let form = e.target.closest('form');
      let inputField = form.querySelector('.js-new-task-field');
      
      addTask(form, function(data){
        
        // Clear input field
        if(inputField) inputField.value = "";

        // Find HTML element
        let taskTemplate = document.getElementById('new-task-template');
        let parentElement = document.querySelector('#list-'+data.list_id+' .task-list');

        // Render task to DOM
        renderTask(data, taskTemplate, parentElement,function(){
          // Update the order of the tasks in the list
          let listElement = $('#list-'+data.list_id+' .js-tasks-list');
          let orderOfAllTasksArray = listElement.sortable('toArray', {attribute: "data-id"});
          var orderOfAllTasks = orderOfAllTasksArray.join(',');
          updateSortedTasks(orderOfAllTasks,data.list_id);
        });
        
      });

    } else if (e.target.classList.contains('js-new-list-btn')){
      app.log("Button 'new list' clicked");
      let form = e.target.closest('form');
      let inputField = form.querySelector('.js-new-list-field');
      
      addList(form, function(data){
        // Clear input field
        if(inputField) inputField.value = "";

        // Find HTML element
        let listTemplate = document.getElementById('new-list-template');
        let parentElement = document.querySelector('.js-list-parent');

        // Render list to DOM
        renderList(data, listTemplate, parentElement);
      });
    } else if (e.target.href){
      window.location = e.target.href;
    }
  });
}

// =====================
// Trigger: Add projects
// =====================
let formAddProject = document.querySelector('.js-form-add-project');
if (formAddProject) {
  formAddProject.addEventListener("submit",function(e) {
    app.log("Form for adding new project was trigged");
    e.preventDefault();

    // Create new project
    submitForm(formAddProject,function(data){
      // Redirect to the projects page
      if(data.id) location.href = "/projects/"+data.id;
    });

  });
}

// =================
// Trigger: Add user
// =================
let formAddUser = document.querySelector(".js-form-add-user");
if (formAddUser) {
  formAddUser.addEventListener("submit",function(e) {
    app.log("Form for adding new user was trigged");
    e.preventDefault();

    // Create new user
    submitForm(formAddUser,function(data){
      // Redirect to the users project page
      if(data.project_id) location.href = "/projects/"+data.project_id;
       
       // Show message that the user was succesfully created
      let statusMessage = document.querySelector('.form-message');
      if(statusMessage) statusMessage.innerHTML =" Användare skapad.";
    });
  });
}

// ====================
// Trigger: Update user
// ====================
let formUpdateUser = document.getElementById("form-update-user");
if(formUpdateUser){
  formUpdateUser.addEventListener("submit",function(e) {
    app.log("Form for updating a user was trigged");
    e.preventDefault();
    submitForm(formUpdateUser,function(data){
      let userElement = document.getElementById('user-'+data.user_id);
      setUserData(data,userElement);
      closeModal("modal-user-update");
    });
  });
}


// ====================
// Trigger: Update task
// ====================
let formTaskUpdate = document.getElementById('form-edit-task');
if(formTaskUpdate){

  formTaskUpdate.addEventListener("submit",function(e){
    app.log("Form submitted");
    e.preventDefault();

    // Submit the form
    submitForm(formTaskUpdate,function(data){
      app.log(data);
      editTaskCallback(data)
    });
  });
}

// ==================
// Cancel task update
// ==================
let btnCancelTaskUpdate = document.querySelector('#modal-task-update .js-btn-cancel');
if(btnCancelTaskUpdate){
  btnCancelTaskUpdate.addEventListener('click',function(e){
    e.preventDefault();
    closeModal('modal-task-update');
  });
}

// ===========================================================
// Enable dragging of tasks to change the order with in a list
// ===========================================================
$( function() {
  $( ".js-tasks-list" ).sortable({
    stop: function(e){
      app.log("Sorting tasks..");
      app.log(e);
      let listId = e.target.dataset.id;
      let orderOfAllTasksArray = $(e.target).sortable('toArray', {attribute: "data-id"});
      var orderOfAllTasks = orderOfAllTasksArray.join(',');
      updateSortedTasks(orderOfAllTasks,listId);
    },
    axis: "y",
    handle: ".js-task-handle",
    cursor: "grabbing"
  });
} );


// ============================================
// Listen for attached files in the trix editor
// ============================================
addEventListener("trix-attachment-add", function(event) {
  if (event.attachment.file) {
    trix__uploadFileAttachment(event.attachment)
  }
})