<?php

login_required();
$list = ui__get_list(get_list_id());

if(empty($list))ui__view_page("error-404.php");

$tasks = ui__get_sorted_tasks($list['id'],$list['tasks_order']);
$list['items'] = $tasks;

// Breadcrumbs
if (!empty(get_project_id())) :
  $breadcrumbs = array(
    ['title' => 'Ombord', 'url' => '/dashboard'],
    ['title' => 'Projekt', 'url' => '/projects/'.get_project_id()],
    ['title' => $list['title']]
  );
else:
  $breadcrumbs = array(
    ['title' => 'Ombord', 'url' => '/dashboard'],
    ['title' => $list['title']]
  );
endif;?>

<?php ui__view_fragment("head.php", ['breadcrumbs' => $breadcrumbs]);?>
<div class="outer-wrapper">
  <div class="inner-wrapper">
    <?php ui__view_module("lists", "list-tasks.php", $list); ?>
  </div>
</div>
<?php ui__view_fragment("foot.php"); ?>