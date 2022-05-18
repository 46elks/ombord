<form method="post" action="/form-submit" id="edit-task-form">

  <label for="title">Titel</label>
  <input type="text" id="title" name="title" value="<?=$module['title'];?>">

  <label for="description">Beskrivning</label>
  <textarea name="description" id="description" cols="30" rows="10"><?=$module['description'];?></textarea>

  <button type="submit" class="btn">Uppdatera</button>
  <a class="btn-inverse js-btn-cancel">Avbryt</a>
  <input type="hidden" name="_action" value="update_task">
  <input type="hidden" name="_method" value="patch">
  <input type="hidden" id="task_id" name="task_id" value="<?=$module['id'];?>">
</form>