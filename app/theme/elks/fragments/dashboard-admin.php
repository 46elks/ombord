<?php $people = ui__get_users(); ?>

<section class="dashboard__section">

  <section id="projects" class="dashboard__section-projects">
    <?php ui__view_module("projects","list-view.php",ui__get_projects());?>
  </section>

  <section id="admin-users" class="dashboard__section-users">
    <header>
      <h2>Älgar</h2>
      <div class="section__nav">
        <ul class="inline-list">
          <li><a href="/new-user">+ Ny älg</a></li>
        </ul>
      </div>
    </header>
    <?php ui__view_module("users","user-list.php", $people); ?>
  </section>

</section>