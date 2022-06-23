<section>
  <header class="pos-rel">
    <h2>Projekt</h2>
    <div class="list__nav">
      <ul class="inline-list">
        <?php if(is_admin()): ?>
          <li><a href="/new-project">+ Nytt projekt</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </header>
</section>

<ul class="block-list">
  <?php foreach ($module as $key => $project) :?>
    <?php $templateLabel = ($project['is_template']) ? " - (mall)" : "";?>
    <li><a href="/projects/<?=$project['id'];?>"><?=$project['name'].$templateLabel;?></a></li>
  <?php endforeach; ?>
</ul>