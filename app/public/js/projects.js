// Delete project
function deleteProject(project_id, callback = null){
  app.log("Preparing to delete project with id "+task_id);

  if(confirm("Vill du ta bort projektet?")){
    apiPost({"_action":"delete_project","project_id" : project_id}, function(data){
      app.log("Project deleted");
      if(typeof callback == 'function') callback(data);
    });
  } else{
    app.log("Project not deleted.");
  }
}

// Function to be called after a project has been deleted
function deleteProjectCallback(data){
  let currentURL = window.location.href;
  app.log(currentURL);

  let parts = currentURL.split("/projects");

  //Redirect URL
  if(parts.length > 1)  location.href = parts[0];

  //Remove project from DOM
  let element = document.getElementById('project-'+data.project_id);
  if(element) element.remove();

}

// Function to be called after a project has been updated
function editProjectCallback(data){
  app.log("Callback: Edit project");

  // Update changes in DOM
  let element = document.getElementById('project-'+data.project_id);
  setProjectData(data,element);
  closeModal("modal-project-update");  
}

// Set project data in DOM
function setProjectData(data, element){
  app.log(data);
  app.log(element);
  
  // Title
  if(data.title) {
    let title = element.querySelector(".js-project-title");
    app.log(title);
    if(title) title.innerHTML = data.title;
  }

  // Description
  if(data.description) {
    let desc = element.querySelector(".js-project-description");
    app.log(desc);
    if(desc) desc.innerHTML = data.description;
  }

  return element;
}

