<?php 

  $description = (isset($module['description'])) ? $module['description'] : "";
  $title = (isset($module['title'])) ? $module['title'] : "";
  $id = (isset($module['id'])) ? $module['id'] : "";
 ?>

<form method="post" action="" id="form-edit-task">
  <input type="text" id="title" name="title" value="<?=htmlspecialchars($title);?>">
  <input id="x" type="hidden" value="<?=htmlspecialchars($description)?>" name="description">
  <trix-editor class="" input="x"></trix-editor>
<br>
  <button type="submit" class="btn js-edit-task">Uppdatera</button>
  <a href="javascript:void(0);" onclick="closeModal('modal-task-update')" class="btn-inverse js-btn-cancel">Avbryt</a>
  <input type="hidden" name="_action" value="update_task">
  <input type="hidden" name="_method" value="patch">
  <input type="hidden" id="task_id" name="task_id" value="<?=htmlentities($id);?>">
</form>