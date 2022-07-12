<?php 
  login_required();
  ui__view_fragment("head.php", ['breadcrumbs' => ui__get_breadcrumbs("new-user")]); 
?>

<div class="outer-wrapper">
  <div class="inner-wrapper">
    <?php if (is_admin()) : ?>
      <section id="add-new-person">
        <form method="post" action="" class="js-form-add-user" id="form-add-user" name="add-user">
          <label for="name">Namn</label>
          <input type="text" id="name" name="name" required class="" placeholder="Anna Andersson" value="">
          <label for="name">E-post</label>
          <input type="text" id="email" name="email" required class="" placeholder="anna@46elks.com" value="">
          <input type="hidden" name="_action" value="add_user">
          <input type="hidden" name="_method" value="post">
          <label for="template_project">Välj onboarding:</label>
          <?php $projects = ui__get_projects(); ?>
          <select name="template_project" id="template_project">
            <?php foreach ($projects as $key => $project) :?>
              <?php if($project['is_template']): ?>
                <option value="<?=$project['id'];?>"><?=$project['name'];?></option>
                <?php endif; ?>
            <?php endforeach;?>
            <option value="0">Ingen onboarding</option>
          </select>
          <br>
          <br>
          <button class="btn" type="submit">Lägg till</button>
        </form>
        <p class="form-message"></p>
      </section>      

      <section>
        <header>
          <h2>Alla älgar</h2>
        </header>
          <?php $people = ui__get_users(); ?>
          <?php ui__view_module("users","user-list.php", $people); ?>
      </section>

    <?php endif; ?>
  </div>
</div>

<?php ui__view_fragment("foot.php");  ?>