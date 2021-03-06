<?php
login_required();
$task_id = get_task_id();
$task = ui__get_task(get_task_id());

if(empty($task)) ui__view_page("error-404.php");

ui__view_fragment("head.php", ['breadcrumbs' => ui__get_breadcrumbs("project")]); 
$is_completed = ($task['is_completed']) ? "checked" : "";
?>

<div class="outer-wrapper">
  <div class="inner-wrapper">

      <section id="single-task">
        <div id="task-<?=$task['id'];?>" class="js-task-wrapper task-wrapper" data-id="<?=$task['id'];?>">
          <header>
            <label class="checkbox-square">
              <h1 class="checkbox__desc task-title js-task-title"><?=$task['title'];?></h1>
              <input type="checkbox" <?=$is_completed;?> onclick="completeTask(<?=$task['id'];?>, this.checked, null);" class="js-complete-task js-task-status" id="<?=$task['id'];?>">
              <span class="checkmark"></span>
            </label>

          </header>

          <div style="" class="trix-content content task-description js-task-description">
            <div class="inner-wrapper">
            <?=$task['description'];?>
            </div>
          </div>

          <?php if(is_admin()):?>
            <button class="js-edit-task btn" onclick="editTask(<?=$task['id'];?>,editTaskCallback);" >Redigera</button>
            <button class="js-delete-task btn-inverse" onclick="deleteTask(<?=$task['id'];?>,deleteTaskCallback);">Ta bort</button>
            <br>
          <?php endif;?>
        </div>
      </section>
    </div>
  </div>

<?php ui__view_fragment("foot.php"); ?>