<?php 
  $user = $data;
  $id     = (isset($user['id'])) ? $user['id'] : "";
  $name   = (isset($user['firstname'])) ? $user['firstname']." " : "";
  $name  .= (isset($user['lastname'])) ? $user['lastname'] : "";
  $title  = (isset($user['title'])) ? $user['title'] : "";
  $phone  = (isset($user['phone_work'])) ? $user['phone_work'] : "";
  $email  = (isset($user['email'])) ? $user['email'] : "";
  $description = (isset($user['description'])) ? $user['description'] : "";

?>

<div id="user-<?=$id;?>" class="user">
  <header>
    <img src="<?=$user['img'];?>" alt="" class="js-user-image user__img">
    <h1 class="user__name js-user-name"><?=$name;?></h1>
    <p class="preamble user__title js-user-title"><?=$title;?></p>

    <div class="user__contact">
      <?php if($phone) :?>
        <a href="tel:<?=$phone;?>" class="user__phone js-user-phone"><?=$phone;?></a>
      <?php endif;?>
      <?php if($email) :?>
        <a href="mailto:<?=$email;?>" class="user__email js-user-email"><?=$email;?></a>
      <?php endif;?>
    </div>
  </header>

  <div class="user__description js-user-description">
    <?=$description;?>
  </div>
  <footer>
    <?php if($id == get_user_id()): ?>
      <a href="javascript:void(0);" onClick="openModal('modal-user-update');" class="btn">Redigera profil</a>
    <?php endif; ?>
  </footer>
</div>