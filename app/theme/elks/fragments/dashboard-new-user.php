<?php 

  $project = ui__get_project(null,get_user_id());
  ui__view_module("projects", "single-project.php", $project);
?>
