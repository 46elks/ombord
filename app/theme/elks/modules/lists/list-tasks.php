<?php 
  // Shows a complete list with tasks inc list title, description
  $id = (isset($module['id'])) ? escape_html($module['id']) : null;
  $title = (isset($module['title'])) ? escape_html($module['title']) : "";
  $description = (isset($module['description'])) ? escape_html($module['description']) : "";

?>

<section id="list-<?=$id;?>" class="js-list-wrapper list__section" data-id="<?=$id;?>">
  <header class="list__header">
    
    <h2 class="js-list-title list__title">
      <?php if(is_admin()): ?>
        <span class="task__handle js-list-handle">::</span>
      <?php endif; ?>
      <a href="<?=ui__get_list_url($id);?>"><?=$title;?></a>
    </h2>
    <div class="list__nav">
      <ul class="inline-list">
        <?php if(is_admin()): ?>
          <li><a href="javascript:void(0);" onClick="editList(<?=$id;?>, editListCallback);" class="js-edit-list-btn"><span class="icon-pencil"></span></a></li>
          <li><a href="javascript:void(0);" onClick="deleteList(<?=$id;?>, deleteListCallback);" class="js-delete-list-btn btn--warning"><span class="icon-bin"></span></a></li>
          <li id="dropdown-list-<?=$id;?>" class="dropdown">
            <a href="javascript:void(0);" onClick="toggleDropdown('dropdown-list-<?=$id;?>');"><span class="icon-menu"></span></a>
            <ul class="block-list">
              <li><a href="javascript:void(0);" data-list="<?=$id;?>" data-project="<?=get_project_id();?>" class="dropdown__item js-dropdown-item js-before-move-list"><span class="icon-arrow-right2"></span> Flytta till</a></li>
              <li><a href="javascript:void(0);" data-list="<?=$id;?>" data-project="<?=get_project_id();?>" class="dropdown__item js-dropdown-item js-before-copy-list"><span class="icon-copy"></span> Duplicera till</a></li>
            </ul>
          </li>
        <?php endif; ?>
      </ul>
    </div>
    <p class="js-list-description list__description preamble"><?=$description;?></p>
  </header>

  <?php ui__view_module("tasks", "list-view.php", $module);?>
  
  <?php if (is_admin()) :
    ui__view_module("tasks", "form-add-task.php", ['list_id' => $id]);
  endif; ?>

</section>
