<?php 
  $projects = ui__get_projects();
?>
<div id="modal-list-copy" class="js-modal modal hidden">
  <div class="modal__content">
    <div class="inner-wrapper">
        <a href="javascript:void(0);" onclick="closeModal('modal-list-copy')" class="modal__close-btn js-btn-close icon-cross"></a>
        <h2 class="modal__title">Kopiera listan</h2>
        <p class="modal__description">Välj vilket projekt du vill kopiera listan till.</p>
        <ul class="block-list column-list__2">
          
        <?php foreach ($projects as $key => $project) :?>
          <li>
            <p><strong><a href="javascript:void(0);" class="js-copy-list" data-target="<?=$project['id'];?>" ><?=$project['name'];?></a></strong><br><small><em><?=$project['title'];?></em></small></p>
          </li>
          <!--<li>
            <a href="javascript:void(0);" class="" onclick="copyList(<?=get_project_id();?>, <?=$project['id'];?>, <?=get_list_id();?>, moveListCallback)"><?=$project['name'];?></a>
          </li>-->
        <?php endforeach; ?>
        </ul>
      </div>
  </div>
</div>