<?php 
  
  $user           = $module;
  $img            = (isset($user['img']) && !empty($user['img'])) ? $user['img'] : "/img/user.jpg";
  $id             = (isset($user['id'])) ? $user['id'] : "";
  $firstname      = (isset($user['firstname'])) ? ucfirst($user['firstname']) : "&nbsp;";
  $lastname       = (isset($user['lastname'])) ? ucfirst($user['lastname']) : "&nbsp;";
  $name           = $firstname ." ".$lastname;
  $title          = (isset($user['title'])) ? ucfirst($user['title']) : "&nbsp;";
  $email          = (isset($user['email'])) ? strtolower($user['email']) : "";
  $phone_work     = (isset($user['phone_work'])) ? strtolower($user['phone_work']) : "";
  $phone_private  = (isset($user['phone_private'])) ? strtolower($user['phone_private']) : "";

?>

<div class="contact-card">
  <a href="/team/<?=$id;?>">
    <img class="contact-card__img js-user-image" src="<?=$img;?>">
  </a>
  <p class="contact-card__name js-user-name"><?=$name;?></p>
  <p class="contact-card__title js-user-title"><?=$title;?></p>
  <div class="contact-card__contact-info">
    <ul>
      <li>
        <span class="contact-card__label"><span class="icon-envelop"></span> E-post</span>
        <span class="js-user-email contact-details contact-card__email"><?=$email;?></span>
      </li>
        <li>
          <span class="contact-card__label"><span class="icon-phone"></span> Jobb</span>
          <span class="js-user-phone contact-details contact-card__phone"><?=$phone_work;?></span>
        </li>
        <li>
          <span class="contact-card__label"><span class="icon-phone"></span> Privat</span>
          <span class="js-user-phone contact-details contact-card__phone"><?=$phone_private;?></span>
        </li>
    </ul>
  </div>
  <footer>
    <a href="/team/<?=$id;?>" class="btn btn--sm btn-inverse--purple">Mer om <?=$firstname;?> <span class="icon-arrow-right2"></span></a>
  </footer> 
</div>