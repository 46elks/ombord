<?php 

  // ===============
  // Breadcrumb view 
  // ===============

  if(isset($module)): ?>
    <nav class="breadcrumbs">
      <ul class="inline-list">
        <?php foreach ($module as $key => $crumb) :?>
          <?php if(isset($crumb['url'])): ?>
            <li class="breadcrumbs__item"><a href="<?=$crumb['url'];?>"><?=$crumb['title'];?></a></li>
          <?php else: ?>
            <li class="breadcrumbs__item"><?=$crumb['title'];?></li>
          <?php endif; ?>
        <?php endforeach; ?>
      </ul>
    </nav>
  <?php endif; ?>