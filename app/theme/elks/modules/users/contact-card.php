<?php if(empty($module["img"])) $module["img"] = "/img/user.jpg"; ?>

<div class="contact-card">
  <a href="/team/<?=$module['id'];?>">
    <img class="contact-card__img js-user-image" src="<?=$module["img"];?>">
  </a>
  <h4 class="contact-card__name js-user-name"><?=$module["firstname"]." ".$module["lastname"];?></h4>
  <p class="contact-card__title js-user-title"><?=$module["title"];?></p>
  <div class="contact-card__contact-info">
    <ul>
      <li>
        <img class="icon" src="img/paper-plane-solid.svg" width="20"><span class="js-user-email contact-details"><?=$module["email"];?></span>
      </li>
      <li>
        <img class="icon" src="img/phone-solid.svg" width="20"><span class="js-user-phone contact-details"><?=$module["phone_work"];?></span>
      </li>
    </ul>
  </div>  
</div>