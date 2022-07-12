<?php

// Single list view

login_required();
$list = ui__get_list(get_list_id());

if(empty($list))ui__view_page("error-404.php");

$tasks = ui__get_sorted_tasks($list['id'],$list['tasks_order']);
$list['items'] = $tasks;

?>

<?php ui__view_fragment("head.php", ['breadcrumbs' => ui__get_breadcrumbs("project")]);?>
<div class="outer-wrapper">
  <div class="inner-wrapper">
    <?php ui__view_module("lists", "list-tasks.php", $list); ?>
  </div>
</div>
<?php ui__view_fragment("foot.php"); ?>