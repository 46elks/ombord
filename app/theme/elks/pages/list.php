<?php

// Single list view

login_required();
$list = ui__get_list(get_list_id());

if(empty($list))ui__view_page("error-404.php");

$tasks        = ui__get_sorted_tasks($list['id'],$list['tasks_order']);
$id           = (isset($list['id'])) ? escape_html($list['id']) : null;
$title        = (isset($list['title'])) ? escape_html($list['title']) : "";
$description  = (isset($list['description'])) ? escape_html($list['description']) : "";

$list['items'] = $tasks;

?>

<?php ui__view_fragment("head.php", ['breadcrumbs' => ui__get_breadcrumbs("project")]);?>

<div class="outer-wrapper">
  <div class="inner-wrapper">

    <section id="list-<?=$id;?>" class="section--page-header section--single-list js-list-wrapper" data-id="<?=$id;?>">

      <header>
        <h1 class="js-list-title list__title"><?=$title;?></h1>
        <div class="section__nav">
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
      
      <?php ui__view_module("tasks", "list-view.php", $list);?>

      <?php if (is_admin()) :
        ui__view_module("tasks", "form-add-task.php", ['list_id' => $id]);
      endif; ?>

    </section>


  </div>
</div>
<?php ui__view_fragment("foot.php"); ?>