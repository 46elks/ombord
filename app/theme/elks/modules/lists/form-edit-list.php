<?php 
   if(!isset($module['title'])) escape_html($module['title']) = "";
   if(!isset($module['description'])) escape_html($module['description']) = "";
   if(!isset($module['id'])) escape_html($module['id']) = "";
 ?>

<form method="post" action="/form-submit" id="edit-list-form">

  <label for="title">Titel</label>
  <input type="text" id="title" name="title" value="<?=$module['title'];?>">

  <label for="description">Beskrivning</label>
  <textarea name="description" id="description" cols="30" rows="10"><?=$module['description'];?></textarea>

  <button type="submit" class="btn">Uppdatera</button>
  <a class="btn-inverse js-btn-cancel">Avbryt</a>
  <input type="hidden" name="_action" value="update_list">
  <input type="hidden" name="_method" value="patch">
  <input type="hidden" id="list_id" name="list_id" value="<?=$module['id'];?>">
</form>