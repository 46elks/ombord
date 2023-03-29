<?php 
  $id = (isset($module['id'])) ? escape_html($module['id']) : "";
  $title = (isset($module['title'])) ? escape_html($module['title']) : "";
  $is_completed = (isset($module['is_completed'])) ? (bool)$module['is_completed'] : false; 
  $completed_class = ($is_completed) ? "task__is_completed" : "";
?>

<li id="task-<?=$id;?>" class="task-wrapper js-task-wrapper js-task-object pos-rel <?=$completed_class;?>" data-id="<?=$id;?>">
  <?php if($is_completed) : ?>
    <input disabled class="task__checkbox js-complete-task" type="checkbox" checked name="" id="<?=$id;?>">
  <?php endif; ?>
  <?php if(is_admin()): ?>
    <span class="task__handle js-task-handle">::</span>
  <?php endif; ?>
  <a href="<?=ui__get_task_url($id);?>" class="js-task-title task__title"><?=$title;?></a>
  <?php if(is_admin()): ?>
    
    <nav class="task__menu">
      <ul class="inline-list">
        <?php if(is_admin()): ?>
          <li><a href="javascript:void(0);" data-task="<?=$id;?>" class="icon-pencil js-before-edit-task"></a></li>
          <li><a href="javascript:void(0);" onClick="deleteTask(<?=$id;?>, deleteTaskCallback);" class="js-delete-task-btn btn--warning icon-bin"></a></li>
        <?php endif; ?>
      </ul>
    </nav>
  <?php endif; ?>
</li>