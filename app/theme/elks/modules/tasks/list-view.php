<?php 

  $id = (isset($module['id'])) ? escape_html($module['id']) : "";
  $items = (isset($module['items'])) ? $module['items'] : [];

?>

<ul class="js-tasks-list task-list" data-id="<?=$id;?>">
  <?php if(!empty($items)):?>
    <?php foreach ($items as $key => $item) :?>
      <?php ui__view_module("tasks", "task.php", $item);?>
    <?php endforeach;?>
  <?php endif; ?>
</ul>