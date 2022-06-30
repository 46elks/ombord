<form method="post" action="" class="js-form-add-task" name="add-task">
  <input type="hidden" name="_action" value="add_task">
  <input type="hidden" name="_method" value="post">
  <input type="hidden" name="list_id" value="<?=$module['list_id'];?>">
  <div class="input-group input-inline">
    <input type="text" name="title" id="new-task-field" class="js-field-title new-task-field field--sm" placeholder="Ny uppgift" value="">
    <button class="btn-inverse btn--sm js-new-task-btn">Lägg till uppgift</button>
  </div>
</form>

<?php ui__view_module("tasks", "template-new-task.php", []);?>