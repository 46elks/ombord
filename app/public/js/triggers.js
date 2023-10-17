// ======================
// Document CHANGE events
// ======================
document.addEventListener("change",function(e){
  app.log(e);
  app.log(e.target);

  // ======================
  // Trigger: Complete task
  // ======================
  if(e.target.classList.contains('js-complete-task')){
    app.log("Trigger: Complete task");
    completeTask(e.target.dataset.task, e.target.checked)
  }

});


// =====================
// Document CLICK events
// =====================
document.addEventListener("click",function(e){
  app.log(e);
  app.log(e.target);

  // =================
  // Trigger: Add task
  // =================
  if(e.target.classList.contains('js-new-task')){
    app.log("Trigger: New task");
    e.preventDefault();

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

  // ==================
  // Trigger: Edit task
  // ==================
  } else if(e.target.classList.contains('js-before-edit-task')){
    app.log("Trigger: Before edit task");
    beforeEditTask(e.target.dataset.task);
    

  } else if(e.target.classList.contains('js-edit-task')){
    app.log("Trigger: Edit task");
    e.preventDefault();

    submitForm(e.target.form, function(data){
      app.log(data);
      editTaskCallback(data)
    });


  // =====================
  // Trigger: Delete task
  // =====================
  } else if(e.target.classList.contains('js-delete-task')){
    app.log("Trigger: Delete task");
    e.preventDefault();
    deleteTask(e.target.dataset.task, deleteTaskCallback);


  // =================
  // Trigger: Add list
  // =================
  } else if (e.target.classList.contains('js-new-list')){
    app.log("Trigger: New list");
    e.preventDefault();

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


  // ===================
  // Trigger: Move lists
  // ===================
  } else if (e.target.classList.contains('js-before-move-list')){
    list.currentProjectId = e.target.dataset.project;
    list.currentListId = e.target.dataset.list;
    openModal('modal-list-move');

  } else if(e.target.classList.contains('js-move-list')){
    list.targetProjectId = e.target.dataset.target;
    list.move(function(data){
      location.href = "/projects/"+data.project_id+"/lists/"+data.list_id;
    });


  // ===================
  // Trigger: Copy lists
  // ===================
  } else if (e.target.classList.contains('js-before-copy-list')){
    list.currentProjectId = e.target.dataset.project;
    list.currentListId = e.target.dataset.list;
    openModal('modal-list-copy');
  
  } else if(e.target.classList.contains('js-copy-list')){
    list.targetProjectId = e.target.dataset.target;
    list.copy(function(data){
      location.href = "/projects/"+data.project_id+"/lists/"+data.list_id;
    });


  // =====================
  // Trigger: Add projects
  // =====================
  } else if (e.target.classList.contains('js-add-project')){
    app.log("Trigger: Add project");
    e.preventDefault();

    e.target.classList.add("hidden"); // Hidde submit button
    e.target.nextElementSibling.classList.remove("hidden"); // Show loader
    
    submitForm(e.target.form,function(data){
      // Redirect to the projects page
      if(data.id) location.href = "/projects/"+data.id;
    });


  // ======================
  // Trigger: Edit projects
  // ======================
  } else if (e.target.classList.contains('js-edit-project')){
    app.log("Trigger: Edit project");
    e.preventDefault();
    
    submitForm(e.target.form,function(data){
      editProjectCallback(data)
    });


  // ==================
  // Trigger: Add user
  // ==================
  } else if (e.target.classList.contains('js-add-user')){
    app.log("Trigger: Add user");
    e.preventDefault()
    
    submitForm(e.target.form,function(data){
      // Redirect to the users project page
      if(data.project_id) location.href = "/projects/"+data.project_id;
       
      // Show message that the user was succesfully created
      let statusMessage = document.querySelector('.form-message');
      if(statusMessage) statusMessage.innerHTML =" Användare skapad.";
    });


  // ==================
  // Trigger: Update user
  // ==================
  } else if (e.target.classList.contains('js-update-user')){
    app.log("Trigger: Update user");
    e.preventDefault()
    
    submitForm(e.target.form,function(data){
      let userElement = document.getElementById('user-'+data.user_id);
      if(userElement){
        setUserData(data,userElement);
        closeModal("modal-user-update");
      }else{
        location.reload(true)
      }
    });
  }
});


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
// Enable dragging of lists to change the order
// ============================================
$( function() {
  $( ".js-project-lists" ).sortable({
    tolerance: "pointer",
    placeholder: "sortable-placeholder",
    stop: function(e,ui){
      app.log("Sorting lists..");
      let projectWrapper = $(e.target).parents(".js-project-wrapper")[0];
      let projectId = projectWrapper.dataset.id;
      let orderOfAllListssArray = $(e.target).sortable('toArray', {attribute: "data-id"});
      var orderOfAllListss = orderOfAllListssArray.join(',');
      updateSortedLists(orderOfAllListssArray, projectId);

      setTimeout(function(){
        $(ui.item.parent()).removeClass("drag-activated")
      },450)
    },
    start:function(e,ui){
      app.log("start")
      $(e.currentTarget).addClass("drag-activated")
      $(this).sortable("refreshPositions")
    },
    activate: function(e, ui){
      app.log("activate")
    },
    axis: "y",
    handle: ".js-list-handle",
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

// ==================================================
// Open all links in a new window, in the trix editor
// ==================================================
let trixContent = document.querySelector(".trix-content");
if(trixContent){
  trixContent.addEventListener("click", function(event) {
    var el = event.target
    if (el.tagName === "A" && !el.isContentEditable) {
      el.setAttribute("target", "_blank")
    }
  }, true)
}