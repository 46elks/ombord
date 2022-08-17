<?php

  // Show single projects and its lists
  $project       = $module; 
  $id            = (isset($project['id'])) ? $project['id'] : "";
  $title         = (isset($project['title'])) ? $project['title'] : "";
  $description   = (isset($project['description'])) ? $project['description'] : "";

?>

<section id="project-<?=$id;?>" class="project__section">

  <header>
    <h1 class="js-project-title project__title"><?=$project['title'];?></h1>
    <p class="js-project-description project__title preamble"><?=$description;?></p>
    <nav class="project__menu">
        <ul class="inline-list">
          <?php if(is_admin()): ?>
            <li><a href="javascript:void(0);" onclick="openModal('modal-project-update')"><span class="icon-pencil"></span></a></li>
            <li><a href="javascript:void(0);" onClick="deleteProject(<?=$id;?>, deleteProjectCallback);" class="js-delete-project-btn btn--warning"><span class="icon-bin"></span></a></li>
          <?php endif; ?>
        </ul>
      </nav>
  </header>

  <?php
    $lists = ui__api_get("/lists", ["project_id" => $id]);
    ui__view_module("lists", "list-module-01.php", $lists);
  ?>
  
</section>