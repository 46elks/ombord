<?php $completed_class = ($module['is_completed']) ? "task__is_completed" : "";?>

<li id="task-<?=$module['id'];?>" class="js-task-wrapper js-task-object <?=$completed_class;?>" data-id="<?=$module['id'];?>">
  <?php if($module['is_completed']) : ?>
    <input disabled class="task__checkbox js-complete-task" type="checkbox" checked name="" id="<?=$module['id'];?>">
  <?php endif; ?>
  <?php if(is_admin()): ?>
    <span class="task__handle js-task-handle">::</span>
  <?php endif; ?>
  <a href="<?=ui__get_task_url($module['id']);?>" class="js-task-title task__title"><?=$module['title'];?></a>
</li>