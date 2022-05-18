<?php $list = $module; ?>
<ul class="js-tasks-list task-list" data-id="<?=$list['id'];?>">
  <?if(!empty($list['items'])):?>
    <?php foreach ($list['items'] as $key => $item) :?>
      <?php ui__view_module("tasks", "task.php", $item);?>
    <?php endforeach;?>
  <?php endif; ?>
</ul>