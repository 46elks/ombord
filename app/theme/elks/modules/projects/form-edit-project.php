<?php 
  
  $id           = (isset($module['id'])) ? $module['id'] : "";
  $title        = (isset($module['title'])) ? $module['title'] : "";
  $description  = (isset($module['description'])) ? $module['description'] : "";
 
 ?>

<form method="post" action="" id="form-edit-project">
  <label for="title">Titel</label>
  <input type="text" id="title" name="title" value="<?=htmlspecialchars($title);?>">
  <label for="description">Beskrivning</label>
  <textarea id="description"  name="description" rows="10"><?=htmlspecialchars($description)?></textarea>
  <br>
  <button type="submit" class="btn">Uppdatera</button>
  <button class="btn-inverse js-btn-cancel">Avbryt</button>
  <input type="hidden" name="_action" value="update_project">
  <input type="hidden" name="_method" value="patch">
  <input type="hidden" id="project_id" name="project_id" value="<?=htmlentities($id);?>">
</form>