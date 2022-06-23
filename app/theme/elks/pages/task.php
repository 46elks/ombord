<?php
login_required();
$task_id = get_task_id();
$task = ui__get_task(get_task_id());

if(empty($task)) ui__view_page("error-404.php");

$breadcrumbs = [
  ['title' => "Ombord", 'url' => "/dashboard"]
];

if (!empty(get_project_id())) :
  array_push($breadcrumbs, ['title' => 'Projekt', 'url' => "/projects/".get_project_id()]);
endif;

if (!empty(get_list_id())) :
  array_push($breadcrumbs, ['title' => 'Listor', 'url' => '/lists/'.get_list_id()]);
endif;

array_push($breadcrumbs,['title' => substr($task['title'],0,20)."..."]);
$head_data = ['breadcrumbs' => $breadcrumbs];

ui__view_fragment("head.php", $head_data); 
$is_completed = ($task['is_completed']) ? "checked" : "";
?>

<div class="outer-wrapper">
  <div class="inner-wrapper">

      <section id="single-task">
        <div id="task-<?=$task['id'];?>" class="js-task-wrapper task-wrapper" data-id="<?=$task['id'];?>">
          <header>
            <label class="checkbox-square">
              <h1 class="checkbox__desc task-title js-task-title"><?=$task['title'];?></h1>
              <input type="checkbox" <?=$is_completed;?> class="js-complete-task js-task-status" id="<?=$task['id'];?>">
              <span class="checkmark"></span>
            </label>
            
          </header>
          <p class="preamble task-description js-task-description"><?=$task['description'];?></p>

          <?php if(is_admin()):?>
            <button class="js-edit-task btn">Redigera</button>
            <button class="js-delete-task btn-inverse">Ta bort</button>
            <br>

            <div id="modal-task-update" class="js-modal modal hidden">
              <div class="modal__content">
                <?php ui__view_module("tasks", "form-edit-task.php", []);?>
              </div>
            </div>
          <?php endif;?>
        </div>
      </section>

    </div>
  </div>


<script>

  let task = document.querySelector('.js-task-wrapper');
  if(task){
   let task_data = getTaskData(task);
   bindTaskEvents(task, task_data);
 }

    // Edit task
    let editModal = document.getElementById('modal-task-update');
    let editBtn  = document.querySelector(".js-edit-task");

    if(editBtn){
      editBtn.addEventListener('click',function(){
        editModal.classList.remove("hidden");

        // Get fresh data from database to ensure it's up to date
        getTask(<?=$task_id;?>,true,function(taskData){
          editModal.querySelector('#title').value = taskData.title;
          editModal.querySelector('#description').value = taskData.description;
          editModal.querySelector('#task_id').value = taskData.id;
        });
      });
    }

    let formTaskUpdate = document.getElementById('edit-task-form');
    if(formTaskUpdate){
      formHandler.init(formTaskUpdate,function(data){
        app.log(data);
        let taskElement = document.getElementById('task-'+data.task_id);
        if(taskElement){
          taskElement.querySelector('.task-title').innerHTML = data.title;
          taskElement.querySelector('.task-description').innerHTML = data.description;
        }
        editModal.classList.add("hidden");
      });
    }

    // Cancel task update
    let cancelBtn = document.querySelector('.js-btn-cancel');
    if(cancelBtn){
      cancelBtn.addEventListener('click',function(e){
        e.preventDefault;
        editModal.classList.add("hidden");
      });
    }

</script>


<?php ui__view_fragment("foot.php"); ?>