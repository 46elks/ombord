<?php 
login_required();

$project_id = get_project_id();
$projects = ui__get_projects($project_id);

if (empty($projects)) ui__view_page('error-404.php');

ui__view_fragment("head.php", ['breadcrumbs' => ui__get_breadcrumbs("project")]); ?>

<div class="outer-wrapper">
  <div class="inner-wrapper">
    <?php if(count($projects) > 1): 
      // Show all projects
      ui__view_module("projects","list-view.php",$projects);
    else:
      // Show a single project
      ui__view_module("projects", "single-project.php", $projects[0]);
    endif;?>
  </div>
</div>

<?php ui__view_fragment("foot.php"); ?>