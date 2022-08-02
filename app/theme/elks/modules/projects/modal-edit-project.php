<?php 

  $project      = $module;
  $id           = (isset($project['id'])) ? $project['id'] : "";
  $is_template  = (bool)(isset($project['is_template'])) ? $project['is_template'] : 0;

?>

<div id="modal-project-update" class="js-modal modal hidden">
  <div class="modal__content">

    <div class="row">
      
      <div class="inner-wrapper">
        <h2 class="text-center">Redigera projektet</h2>
        <?php ui__view_module("projects", "form-edit-project.php", $project);?>
      </div>

      <div class="inner-wrapper">
        <h2>Användare</h2>
        <?php if(!empty($id) && !$is_template): ?>
          <p>Välj vilka personer som ska ha tillgång till projektet.</p>
          <?php 
              // Get all users and put a mark on the ones who has beed assigned the project
          $project_users_list = ui__get_project_users($id);
          $users = ui__get_users();
          ?>
          <ul class="block-list checkbox-list">
            <?php foreach ($users as $key => $user) :?>
              <?php
                  // Check whether or not the user is already assigned to the project
              $checked = (array_search($user['id'], array_column($project_users_list, 'id')) !== false) ? "checked" : "";
              ?>
              <li>
                <input type="checkbox" <?=$checked;?> onclick="toggleUserProject(<?=$user['id'];?>,<?=$project['id'];?>, this.checked, null);">
                <span><?=$user['firstname'];?></span>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p>Detta är en projektmall och därför kan du inte välja vilka personer som ska ha tillgång till projektet.</p>
        <?php endif; ?>
      </div>
    </div>


  </div>
</div>