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
    <section id="task-<?=$task['id'];?>" class="task__section js-task-wrapper task-wrapper" data-id="<?=$task['id'];?>">
      <header>
        <label class="checkbox-square" for="<?=$task['id'];?>">
          <h1 class="checkbox__desc task__title js-task-title"><?=$task['title'];?></h1>
          <input type="checkbox" <?=$is_completed;?>  data-task="<?=$task['id'];?>" class="js-complete-task js-task-status" id="<?=$task['id'];?>">
          <span class="checkmark"></span>
        </label>
      </header>

      <div style="" class="trix-content content task__description js-task-description">
        <div class="inner-wrapper">
          <?=$task['description'];?>
        </div>
      </div>

      <?php if(is_admin()):?>
        <button class="js-before-edit-task btn" data-task="<?=$task['id'];?>">Redigera</button>
        <button class="js-delete-task btn-inverse" data-task="<?=$task['id'];?>">Ta bort</button>
        <br>
      <?php endif;?>
    </section>
  </div>
</div>

<?php ui__view_fragment("foot.php"); ?>