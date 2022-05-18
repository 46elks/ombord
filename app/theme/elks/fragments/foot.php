<section id="footer">
    <div class="outer-wrapper">
        <div class="inner-wrapper">
        </div>
    </div>
</section>

<?php ui__view_module("lists", "modal-edit-list.php", []); ?>
<script>
    
  // ========
  // Add list
  // ========
  let formAddList = document.getElementById('form-add-list');
  if(formAddList){
    app.log(formAddList);
    formHandler.init(formAddList,function(data){
      console.log("New list created");
      console.log(data);
      // formAddList.querySelector('#new-list-field').value = "";
      // let listElement = document.getElementById('new-list-template');
      // let parentElement = document.querySelector('.js-list-parent');
      // renderList(data, listElement, parentElement);
    });
  }


  // ========
  // Add task
  // ========
  let taskTemplate = document.querySelector('#new-task-template');

  // Form for adding new tasks
  let formsAddTask = document.querySelectorAll('.js-form-add-task');
  app.log("Found "+formsAddTask.length+" task forms");

  for (var i = formsAddTask.length - 1; i >= 0; i--) {
    
    let formAddTask = formsAddTask[i];
    let titleField = formsAddTask[i].querySelector('.js-field-title');
    app.log(formAddTask);

    formHandler.init(formAddTask,function(data){
      let parentElement = document.querySelector('#list-'+data.list_id+' .task-list');
      app.log(parentElement);
      renderTask(data, taskTemplate, parentElement,function(taskElement){
        bindTaskEvents(taskElement, data);
      });

      // Clear title input field
      titleField.value = "";
    });
  }

  // ===========
  // Add project
  // ===========
  let formAddProject = document.querySelector('.js-form-add-project');
  if (formAddProject) {
    formHandler.init(formAddProject,function(data){
      if(data.id){
        location.href = "/projects/"+data.id;
      }
    });
  }
    
</script>
</body>
</html>