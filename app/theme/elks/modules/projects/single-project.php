<?php 
  // Show single projects and its lists
  $project = $module; 
?>
<h1><?=$project['title'];?></h1>
<p class="preamble"><?=$project['description'];?></p>
<?php
$lists = ui__api_get("/lists", ["project_id" => $project['id']]);
ui__view_module("lists", "list-module-01.php", $lists);