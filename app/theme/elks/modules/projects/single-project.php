<?php

  // Show single projects and its lists
  $project       = $module; 
  $id            = (isset($project['id'])) ? $project['id'] : "";
  $title         = (isset($project['title'])) ? $project['title'] : "";
  $description   = (isset($project['description'])) ? $project['description'] : "";

?>

<section id="project-<?=$id;?>" class="js-project-wrapper project__section" data-id="<?=$id;?>">

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
    $lists = ui__sort_items($lists, $project['lists_order']);
  ?>

  <section id="lists">
    <div class="js-list-parent js-project-lists">
      <?php foreach ($lists as $key => $list) :
        $list['items'] = ui__get_sorted_tasks($list['id'],$list['tasks_order']);
        ui__view_module("lists", "list-tasks.php", $list);
      endforeach;?>
    </div>
    <br>
    <br>
    <br>
    <?php if(is_admin()) ui__view_module("lists", "form-add-list.php", []);?>
  </section>

<?php ui__view_module("lists", "template-new-list.php", []);?>
  
</section>