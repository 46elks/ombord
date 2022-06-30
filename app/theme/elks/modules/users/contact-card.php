<?php if(empty($module["img"])) $module["img"] = "/img/user.jpg"; ?>

<div class="contact-card">
  <a href="/team/<?=escape_html($module['id']);?>">
    <img class="contact-card__img js-user-image" src="<?=escape_html($module["img"]);?>">
  </a>
  <h4 class="contact-card__name js-user-name"><?=escape_html($module["firstname"])." ".escape_html($module["lastname"]);?></h4>
  <p class="contact-card__title js-user-title"><?=escape_html($module["title"]);?></p>
  <div class="contact-card__contact-info">
    <ul>
      <li>
        <img class="icon" src="img/paper-plane-solid.svg" width="20"><span class="js-user-email contact-details"><?=escape_html($module["email"]);?></span>
      </li>
      <li>
        <img class="icon" src="img/phone-solid.svg" width="20"><span class="js-user-phone contact-details"><?=escape_html($module["phone_work"]);?></span>
      </li>
    </ul>
  </div>  
</div>