<?php $people = ui__get_users(); ?>

<section id="projects">
  <?php ui__view_module("projects","list-view.php",ui__get_projects());?>
</section>

<section id="admin-users">
  <header class="pos-rel">
    <h2>Älgar</h2>
    <div class="list__nav">
      <ul class="inline-list">
        <li><a href="/new-user">+ Ny älg</a></li>
      </ul>
    </div>
  </header>
<?php ui__view_module("users","user-list.php", $people); ?>
</section>


