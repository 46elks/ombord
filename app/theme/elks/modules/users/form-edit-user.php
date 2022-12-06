<?php
  $user         = $module; 
  $description  = (isset($user['description'])) ? htmlentities($user['description']) : "";
  $img          = (isset($user['img'])) ? htmlentities($user['img']) : "";
  $firstname    = (isset($user['firstname'])) ? htmlentities($user['firstname']) : "";
  $lastname     = (isset($user['lastname'])) ? htmlentities($user['lastname']) : "";
  $title        = (isset($user['title'])) ? htmlentities($user['title']) : "";
  $email        = (isset($user['email'])) ? htmlentities($user['email']) : "";
  $phone_work     = (isset($user['phone_work'])) ? htmlentities($user['phone_work']) : "";
  $phone_private  = (isset($user['phone_private'])) ? htmlentities($user['phone_private']) : "";
?>

<form method="post" action="" class="js-form" id="form-update-user">
  <input id="x" type="hidden" value="<?=$description;?>" name="description">
  <trix-editor class="" input="x"></trix-editor>
  <br>
  <label for="img">Profilbild</label>
  <input type="text" id="img" name="img" placeholder="URL till bild" value="<?=$img;?>">
  <br>
  <label for="firstname">Förnamn</label>
  <input type="text" id="firstname" name="firstname" placeholder="Förnamn" value="<?=$firstname;?>">
  <br>
  <label for="lastname">Efternamn</label>
  <input type="text" id="lastname" name="lastname" placeholder="Efternamn" value="<?=$lastname;?>">
  <br>
  <label for="title">Titel</label>
  <input type="text" id="title" name="title" placeholder="Titel" value="<?=$title;?>">
  <br>
  <label for="email">E-postadress</label>
  <input type="text" id="email" name="email" placeholder="E-postadress" value="<?=$email;?>">
  <br>
  <label for="phone_work">Telefonnummer (jobb)</label>
  <input type="text" id="phone_work" name="phone_work" placeholder="Jobbnummer" value="<?=$phone_work;?>">
  <br>
  <label for="phone_private">Telefonnummer (privat)</label>
  <input type="text" id="phone_private" name="phone_private" placeholder="Privat nummer" value="<?=$phone_private;?>">
  <br>
  <br>
  <input type="hidden" name="_action" value="update_user">
  <input type="hidden" name="user_id" value="<?=htmlentities(get_user_id());?>">
  <button type="submit" class="btn">Spara</button>
  <a href="javascript:void(0);" onClick="closeModal('modal-user-update');" class="btn-inverse js-btn-cancel">Avbryt</a>
</form>