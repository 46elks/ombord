<ul class="block-list">
<?php foreach ($module as $key => $user) :?>
  
    <?php 
      $current_user_class = ($user['id'] == get_user_id()) ? "current-user" : "";
      $new_user = (!$user['is_admin'])  ? " - ny älg 🥳 " : "";
    ?>
    <li class="<?=$current_user_class;?>">
    <a href="team/<?=escape_html($user['id']);?>">
      <?=$user['firstname'];?>
    </a>
    <?=$new_user;?>
  </li>  
<?php endforeach; ?>
</ul>