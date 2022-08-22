<?php

  $user           = $data;
  $id             = (isset($user['id'])) ? $user['id'] : "";
  $firstname      = (isset($user['firstname'])) ? $user['firstname']." " : "";
  $lastname       = (isset($user['lastname'])) ? $user['lastname'] : "";
  $name           = $firstname." ".$lastname;
  $title          = (isset($user['title'])) ? $user['title'] : "";
  $phone_work     = (isset($user['phone_work'])) ? $user['phone_work'] : "&nbsp;";
  $phone_private  = (isset($user['phone_private'])) ? $user['phone_private'] : "&nbsp;";
  $email          = (isset($user['email'])) ? $user['email'] : "&nbsp;";
  $description    = (isset($user['description'])) ? $user['description'] : "";
  $img            = (isset($user['img']) && !empty($user['img'])) ? $user['img'] : "/img/user.jpg";

?>

<div id="user-<?=$id;?>" class="user">
  <header>
    <img src="<?=$img;?>" alt="" class="js-user-image user__img">
    <h1 class="user__name js-user-name"><?=$name;?></h1>
    <p class="preamble user__title js-user-title"><?=$title;?></p>

    <div class="user__contact">
      <div class="contact-card__contact-info">
        <ul>
          <li>
            <span class="contact-card__label"><span class="icon-envelop"></span> E-post</span>
            <span><a href="mailto:<?=$email;?>" class="js-user-email contact-details contact-card__email"><?=$email;?></a></span>
          </li>
          <li>
            <span class="contact-card__label"><span class="icon-phone"></span> Jobb</span>
            <span><a href="tel:<?=$phone_work;?>" class="js-user-phone contact-details contact-card__phone"><?=$phone_work;?></a></span>
          </li>
          <li>
            <span class="contact-card__label"><span class="icon-phone"></span> Privat</span>
            <span><a href="tel:<?=$phone_private;?>" class="js-user-phone contact-details contact-card__phone"><?=$phone_private;?></a></span>
          </li>
        </ul>
      </div>
    </div>
    
  </header>

  <div class="trix-content user__description js-user-description">
    <?=$description;?>
  </div>
  <footer>
    <?php if($id == get_user_id()): ?>
      <a href="javascript:void(0);" onClick="openModal('modal-user-update');" class="btn">Redigera profil</a>
    <?php endif; ?>
  </footer>
</div>
