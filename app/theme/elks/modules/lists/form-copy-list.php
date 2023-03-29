<?php 
  $list     = $module;
  $projects = ui__get_projects();
?>

<form method="post" action="" class="js-form-copy-list">
  <select name="new_project">
    <?php foreach ($projects as $key => $project) :?>
      <option value="<?=$project['id'];?>"><?=$project['name'];?></option>
    <?php endforeach; ?>
    </select>
    <input type="hidden" name="_action" value="copy_list">
    <input type="hidden" name="_method" value="post">
    <input type="hidden" name="project_id" value="<?=get_project_id();?>">
    <input type="hidden" name="list_id" value="<?=$list['id']?>">
    <br>
    <div class="input-group input-inline">
      <button type="submit" class="js-copy-list-btn btn">Duplicera till valda projekt</button>
    </div>
</form>