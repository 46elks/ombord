<?php

  login_required();
  
  // Start printing the view
  ui__view_fragment("head.php", ['breadcrumbs'=>ui__get_breadcrumbs("new-project")]);
?>

<div class="outer-wrapper">
  <div class="inner-wrapper">
    
    <section>
      <header>
        <h1>Skapa nytt projekt</h1>
      </header>

      <form action="" method="post" class="js-form-add-project" name="new-project">
        <label for="name">Projektnamn</label>
        <input type="text" id="name" name="name" placeholder="Onboarding Anna">
        <br>
        <label for="title">Titel</label>
        <input type="text" id="title" name="title" placeholder="Välkommen som ny älg">
        <br>
        <label for="title">Beskrivning</label>
        <textarea name="description" id="description" cols="30" rows="10"></textarea>
        <br>
        <label class="checkbox-square">
          <p class="checkbox__desc">Skapa som mall</p>
          <input type="checkbox" name="is_template" id="is_template" value="1">
          <span class="checkmark checkmark--sm"></span>
        </label>
        <br>
        <br>
        <label for="template_project">Skapa från mall:</label>
        <select name="template_project" id="template_project">
          <?php $projects = ui__get_projects(); ?>
          <option value="0" default >Ingen mall</option>
          <?php foreach ($projects as $key => $project) :?>
            <?php if($project['is_template']): ?>
              <option value="<?=$project['id'];?>"><?=escape_html($project['name']);?></option>
              <?php endif; ?>
          <?php endforeach;?>
        </select>
        <input type="hidden" name="_action" value="add_project">
        <br>
        <br>
        <br>
        <input type="submit" class="btn js-add-project" value="Skapa projekt">
        <br>
        
      </form>

    </section>

  </div>
</div>

<?php ui__view_fragment("foot.php");?>
