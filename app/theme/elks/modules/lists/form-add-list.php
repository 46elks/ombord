<form method="post" action="/form-submit" class="" id="form-add-list" name="add-list">
  <input type="hidden" name="_action" value="add_list">
  <input type="hidden" name="_method" value="post">
  <input type="hidden" name="project_id" value="<?=get_project_id();?>">
  <div class="input-group input-inline">
    <input type="text" name="title" id="new-list-field" class="js-field-title new-list-field field--sm" placeholder="Ny lista" value="">
    <button type="submit" class="btn-inverse btn--sm">Skapa lista</button>
  </div>
</form>