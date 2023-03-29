<?php 
  $projects = ui__get_projects();
?>

<div id="modal-list-move" class="js-modal modal hidden">
  <div class="modal__content">
    <div class="inner-wrapper">
        <a href="javascript:void(0);" onclick="closeModal('modal-list-move')" class="modal__close-btn js-btn-close icon-cross"></a>
        <h2 class="modal__title">Flytta listan</h2>
        <p class="modal__description">Välj vilket projekt du vill flytta listan till.</p>
        <ul class="block-list column-list__2">
          
        <?php foreach ($projects as $key => $project) :?>
          <li>
            <p><strong><a href="javascript:void(0);" class="js-move-list" data-target="<?=$project['id'];?>" ><?=$project['name'];?></a></strong><br><small><em><?=$project['title'];?></em></small></p>
          </li>
        <?php endforeach; ?>
        </ul>
      </div>
  </div>
</div>