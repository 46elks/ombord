// Render list to DOM
function renderList(data, listTemplate, parentElement, callback = null){
  
  app.log("Render list");
  app.log(data);
  
  let listElement = listTemplate.content.cloneNode(true);
  listElement = setListData(data, listElement);
  
  // Append list to DOM
  if(parentElement){
    parentElement.prepend(listElement);
  }
  
  listElement = document.getElementById("list-"+data.id);
  
  if(typeof callback == 'function') callback(listElement);
  
}


// Set list data
function setListData(data, listElement){

  // list id
  if(data.id) {
    listElement.querySelector(".js-list-title").href = "/lists/"+data.id;
    listWrapper = listElement.querySelector(".js-list-wrapper");
    if(listWrapper){
      listWrapper.id = "list-"+data.id;
    }else{
      listElement.id = "list-"+data.id;
    }
  }

  // list title
  let listTitle = listElement.querySelector(".js-list-title");
  if(data.title && listTitle) listTitle.innerHTML = data.title;

  // list description
  let listDescription = listElement.querySelector(".js-list-description");
  if(data.description && listDescription) listDescription.innerHTML = data.title;

  return listElement;
}

function bindListEvents(listElement, data){
  
  app.log("Bind list events");

  // Find list metadata from dom if none was provided
  if(!data) data = findListData(listElement);

  // Delete button
  let deleteBtn = listElement.querySelector('.js-delete-list');
  if(deleteBtn){
    deleteBtn.addEventListener('click',function(){
      deleteList(data.id,function(data){
        listElement.remove();
      });
    });
  }
}

function deleteList(list_id, callback = null){
  app.log("Deleting list..");
  if(confirm("Vill du ta bort listan?")){
    apiRequest.send("delete", {"_action":"delete_list","list_id" : list_id},  function(data){
      app.log("List is deleted");
      if(typeof callback == 'function') callback(data);
    });
  }
}


function editList(list_id, callback = null){

  app.log("Editing list..");

  // Show modal
  let modal = document.getElementById('modal-list-update');
  if(modal){
    modal.classList.remove("hidden");

    // Get fresh data from database and prefill the form with it
    getList(list_id,function(data){
      modal.querySelector('#title').value = data.title;
      modal.querySelector('#description').value = data.description;
      modal.querySelector('#list_id').value = data.id;
    });
  }

  // Prepare the update form
  let formUpdate = document.getElementById('edit-list-form');

  if(formUpdate){
    app.log("Prepare list update form");
    formHandler.init(formUpdate, function(data){
      
      app.log("List callback recieved data");
      app.log(data);

      let listElement = document.getElementById('list-'+data.id);
      app.log(listElement);

      if(listElement){
        listElement.querySelector('.js-list-title').innerHTML = data.title;
        listElement.querySelector('.js-list-description').innerHTML = data.description;
      }
      modal.classList.add("hidden");

      if(typeof callback == 'function') callback(data);

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

// Get a single list from API
function getList(list_id, callback=null){
  app.log("Getting list "+list_id);
  apiRequest.send("get", {"_action":"GET_LIST","list_id":list_id}, function(data){

    if(typeof callback == 'function'){
       callback(data);
     }else{
      app.log("getList() could not find a callback function");
     }
  });
}



// Edit list
function editedListCallback(data){
  let listElement = document.getElementById('list-'+data.list_id);

  if(!listElement) return;
  
  // list title
  let listTitle = listElement.querySelector(".js-list-title");
  if(data.title && listTitle) listTitle.innerHTML = data.title;

  // list description
  let listDescription = listElement.querySelector(".js-list-description");
  if(data.description && listDescription) listDescription.innerHTML = data.description;
}

function deletedListCallback(data){
  let currentURL = window.location.href;
  let parts = currentURL.split("/lists");

  // Redirect URL
  if(parts.length > 1) location.href = parts[0];

  // Remove list from dom
  let listElement = document.getElementById('list-'+data.list_id);
  if(listElement) listElement.remove();

}