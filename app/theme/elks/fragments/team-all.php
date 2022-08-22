<?php $people = $data; ?>

<section class="section--page-header">
  <header>
    <h1>Dina kollegor</h1>
    <p class="preamble">Det här är dina nya kollegor som du kommer lära känna, vi finns alla här för frågor - Inga frågor är för små! Vi vill att du ska trivas hos oss.</p>
    <div class="section__nav">
      <ul class="inline-list">
        <?php if(is_admin()): ?>
        <li><a href="/new-user">+ Ny älg</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </header>

</section>

<section id="contacts" class="contact__list">
  <?php foreach ($people as $person) :?>
    <?php ui__view_module("users", "contact-card.php", $person);?>
  <?php endforeach;?>
</section>