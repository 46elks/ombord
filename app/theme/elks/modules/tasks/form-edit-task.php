<form method="post" action="" id="form-edit-task">

  <label for="title">Titel</label>
  <input type="text" id="title" name="title" value="<?=escape_html($module['title']);?>">

  <label for="description">Beskrivning</label>
  <textarea name="description" id="description" cols="30" rows="10"><?=escape_html($module['description']);?></textarea>

  <button type="submit" class="btn">Uppdatera</button>
  <button class="btn-inverse js-btn-cancel">Avbryt</button>
  <input type="hidden" name="_action" value="update_task">
  <input type="hidden" name="_method" value="patch">
  <input type="hidden" id="task_id" name="task_id" value="<?=escape_html($module['id']);?>">
</form>