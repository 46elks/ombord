/*
  
  === API modifiers ===
  - addList()
  - deleteList()
  - getList()

  === DOM modifiers ===
  - renderList()
  - setListData()
  - editList()
  - findListData()
  - findListId()
  - editListCallback()
  - deleteListCallback()

*/

// Create new list
function addList(form, callback = null){
  app.log("Add list");
  app.log(form);
  app.log(form.method);

  submitForm(form,function(data){
    if(typeof callback == 'function') callback(data);
  });
}

// Get a single list from API
function getList(list_id, callback=null){
  app.log("Getting list with id "+list_id);
  apiPost({"_action":"GET_LIST","list_id":list_id}, function(data){
    if(typeof callback == 'function'){
       callback(data);
     }else{
      app.log("getList() could not find a callback function");
     }
  });
}

// Render list to DOM
function renderList(data, listTemplate, parentElement, callback = null){
  
  app.log("Render list");
  app.log(data);
  
  let listElement = listTemplate.content.cloneNode(true);
  listElement = setListData(data, listElement);

  // Append list to DOM
  if(parentElement){
    app.log(parentElement);
    parentElement.append(listElement);
  }
  
  // Find the added list element in DOM
  listElement = document.getElementById("list-"+data.id);

  // Add list ID to the form for adding a task to the list
  let formInput = listElement.querySelector("[name='list_id']");
  if(formInput) formInput.value = data.id;

  // Run callback function (if any wa provided)
  if(typeof callback == 'function') callback(listElement);
  
}

// Set/update list data in DOM
function setListData(data, listElement){

  let id = null;

  if(data.id) {
    id = data.id
  } else if(data.list_id){
    id = data.list_id
  }

  // list id
  if(id) {
    listElement.querySelector(".js-list-title").href = "/lists/"+id;
    listWrapper = listElement.querySelector(".js-list-wrapper");
    if(listWrapper){
      listWrapper.id = "list-"+id;
    }else{
      listElement.id = "list-"+id;
    }
  }

  // list title
  let listTitle = listElement.querySelector(".js-list-title");
  if(data.title && listTitle) listTitle.innerHTML = data.title;

  // list description
  let listDescription = listElement.querySelector(".js-list-description");
  if(data.description && listDescription) listDescription.innerHTML = data.description;

  // edit btn
  let editListBtn = listElement.querySelector(".js-edit-list-btn");
  if(editListBtn && id){
    editListBtn.onclick = function(){editList(id, editListCallback);}
  }

  // delete btn
  let deleteListBtn = listElement.querySelector(".js-delete-list-btn");
  if(deleteListBtn && id){
    deleteListBtn.onclick = function(){deleteList(id, deleteListCallback);}
  }

  return listElement;
}

// Delete the list
function deleteList(list_id, callback = null){
  app.log("Preparing to delete list with id "+list_id);
  
  if(confirm("Vill du ta bort listan?")){
    apiPost({"_action":"delete_list","list_id" : list_id}, function(data){
      app.log("List is deleted");
      if(typeof callback == 'function') callback(data);
    });
  } else{
    app.log("List not deleted.");
  }
}

// Update the list
function updateList(form, callback = null){

  submitForm(form,function(data){
    app.log("The list updates was successfully submitted");

    // Run callback
    if(typeof callback == 'function') callback(data);

  });
  
}

// Edit the list
function editList(list_id, callback = null){

  app.log("Enable list edit mode for list with id: " + list_id);

  // Find modal
  let modal = document.getElementById('modal-list-update');

  if(modal){

    // Show modal
    modal.classList.remove("hidden");

    // Get fresh data from database and prefill the form with it
    getList(list_id,function(data){
      modal.querySelector('#title').value = data.title;
      modal.querySelector('#description').value = data.description;
      modal.querySelector('#list_id').value = data.id;
    });
  }

  // Prepare the form for submission
  let formUpdate = document.getElementById('edit-list-form');
  if(formUpdate){
    app.log("Prepare list update form");

    // When submitted..
    formUpdate.addEventListener("submit", function(e){
      e.preventDefault();
      app.log("Form submitted");

      submitForm(formUpdate,function(data){
        app.log("The list updates was successfully submitted");

        // Close the modal
        modal.classList.add("hidden");

        // Update the lists values in DOM
        setListData(data, document.getElementById('list-'+data.list_id))

      });
    });
  }

  // Cancel list update
  let cancelBtn = modal.querySelector('.js-btn-cancel');
  if(cancelBtn){
    cancelBtn.addEventListener('click',function(e){
      e.preventDefault;
      modal.classList.add("hidden");
    });
  }
}


// Get list data from DOM
function findListData(listElement){
  return {
    id: findListId(listElement),
  }
}

// Find list id in DOM
function findListId(listElement){

  if(!listElement) return null;

  let id = listElement.dataset.id;
  if(id) return id
  
  listElement = listElement.querySelector(".js-list-wrapper");
  if(listElement) id = listElement.dataset.id;
  if(id) return id

  return null;

}


// Function to be called after a list has been edited
function editListCallback(data){
  let listElement = document.getElementById('list-'+data.list_id);

  if(!listElement) return;
  
  // list title
  let listTitle = listElement.querySelector(".js-list-title");
  if(data.title && listTitle) listTitle.innerHTML = data.title;

  // list description
  let listDescription = listElement.querySelector(".js-list-description");
  if(data.description && listDescription) listDescription.innerHTML = data.description;
}


// Function to be called after a list has been deleted
function deleteListCallback(data){
  let currentURL = window.location.href;
  let parts = currentURL.split("/lists");

  // Redirect URL
  if(parts.length > 1) location.href = parts[0];

  // Remove list from dom
  let listElement = document.getElementById('list-'+data.list_id);
  if(listElement) listElement.remove();

}

// Toggle between adding and removing a task from a list
function toggleListTask(taskId, listId, state){
  (state) ? addListTask(taskId, listId) : deleteListTask(taskId, listId);
}

// Add a task to a list
function addListTask(taskId, listId){
  let data = {
    _action: "ADD_LIST_TASK",
    task_id: taskId,
    list_id: listId
  }
  apiPost(data,function(data){
    app.log("Task "+taskId+" added to list "+listId);
  });
}

// Remove a task from a list
function deleteListTask(taskId, listId){
  let data = {
    _action: "DELETE_LIST_TASK",
    task_id: taskId,
    list_id: listId
  }
  apiPost(data,function(data){
    app.log("Task "+taskId+" deleted from list "+listId);
  });
}
