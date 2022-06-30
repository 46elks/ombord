<?php $user = $data; ?>
<?php ui__view_module("users", "contact-card.php", $user); ?>
<p class="preamble"><?=$user['description']?></p>

<?php if($user['id'] == get_user_id()): ?>

  <details>
    <summary>Profilinställningar</summary>
    <section>
      <header>
        <h2>Profilinställningar</h2>
      </header>

      <form method="post" action="" class="js-form" id="form-update-user">
        <label for="img">Profilbild</label>
        <input type="text" id="img" name="img" placeholder="URL till bild" value="<?=htmlentities($user['img']);?>">
        <br>
        <label for="firstname">Förnamn</label>
        <input type="text" id="firstname" name="firstname" placeholder="Förnamn" value="<?=htmlentities($user['firstname']);?>">
        <br>
        <label for="lastname">Efternamn</label>
        <input type="text" id="lastname" name="lastname" placeholder="Efternamn" value="<?=htmlentities($user['lastname']);?>">
        <br>
        <label for="title">Titel</label>
        <input type="text" id="title" name="title" placeholder="Titel" value="<?=htmlentities($user['title']);?>">
        <br>
        <label for="email">E-postadress</label>
        <input type="text" id="email" name="email" placeholder="E-postadress" value="<?=htmlentities($user['email']);?>">
        <br>
        <label for="phone">Telefonnummer</label>
        <input type="text" id="phone" name="phone_work" placeholder="Telefonnummer" value="<?=$user['phone_work'];?>">
        <br>
        <label for="password">Lösenord</label>
        <input type="password" id="password" name="password" value="">
        <br>
        <label for="description">Beskrivning</label>
        <textarea name="description" id="description" cols="30" rows="10"><?=htmlentities($user['description']);?></textarea>
        <br>
        <input type="hidden" name="_action" value="update_user">
        <input type="hidden" name="user_id" value="<?=htmlentities(get_user_id());?>">
        <button type="submit" class="btn">Spara</button>
      </form>
      <p class="form-message"></p>
    </section>
  </details>

  <?php endif; ?>