<?php 
  // Shows a complete list with tasks inc list title, description
  $list = $module;
?>

<section id="list-<?=$list['id'];?>" class="js-list-wrapper" data-id="<?=$list['id'];?>">

  <header class="list__header">
    <h2 class="js-list-title list__title"><?=$list['title'];?></h2>
    <div class="list__nav">
      <ul class="inline-list">
        <?php if(!isset($_GET['list_id'])): ?>
        <li><span class="list__show-more"><a href="<?=ui__get_list_url($list['id']);?>">Visa mer</a></span></li>
        <?php endif; ?>
        <?php if(is_admin()): ?>
          <li><a href="javascript:void(0);" onClick="editList(<?=$list['id'];?>, editListCallback);" class="js-edit-list-btn">Redigera</a></li>
          <li><a href="javascript:void(0);" onClick="deleteList(<?=$list['id'];?>, deleteListCallback);" class="js-delete-list-btn btn--warning">Ta bort</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </header>
  <p class="js-list-description list__description"><?=$list['description'];?></p>

  <?php ui__view_module("tasks", "list-view.php", $list);?>
  
  <?php if (is_admin()) :
    ui__view_module("tasks", "form-add-task.php", ['list_id' => $list['id']]);
  endif; ?>

</section>
