<?php 
  $project = ui__get_project(null,get_user_id());
  if(!empty($project)):
    $project_id = $project['id'];
    $lists = ui__api_get("/lists", ["project_id" => $project_id]);
  endif;
?>

<section>
  <h1><?=$project['title'];?></h1>
  <p class="preamble"><?=nl2br($project['description']);?></p>
</section>

<div class="outer-wrapper">
  <div class="inner-wrapper">
    <?php if(!empty($lists)):
      ui__view_module("lists", "list-module-01.php", $lists);
    endif;?>
  </div>
</div>