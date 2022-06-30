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
              <h1 class="checkbox__desc task-title js-task-title"><?=escape_html($task['title']);?></h1>
              <input type="checkbox" <?=$is_completed;?> onclick="completeTask(<?=$task['id'];?>, this.checked, null);" class="js-complete-task js-task-status" id="<?=$task['id'];?>">
              <span class="checkmark"></span>
            </label>
            
          </header>
          <p class="preamble task-description js-task-description"><?=escape_html($task['description']);?></p>

          <?php if(is_admin()):?>
            <button class="js-edit-task btn" onclick="editTask(<?=$task['id'];?>,editTaskCallback);" >Redigera</button>
            <button class="js-delete-task btn-inverse" onclick="deleteTask(<?=$task['id'];?>,deleteTaskCallback);">Ta bort</button>
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

<?php ui__view_fragment("foot.php"); ?>