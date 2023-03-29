<form method="post" action="" class="js-form-add-list" name="add-list">
  <input type="hidden" name="_action" value="add_list">
  <input type="hidden" name="_method" value="post">
  <input type="hidden" name="project_id" value="<?=get_project_id();?>">
  <div class="input-group input-inline">
    <input type="text" name="title" class="js-new-list-field new-list-field field--sm" placeholder="Ny lista" value="">
    <button type="submit" class="js-new-list btn-inverse btn--sm">Skapa lista</button>
  </div>
</form>