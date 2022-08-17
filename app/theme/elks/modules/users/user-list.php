<ul class="block-list">
  <?php foreach ($module as $key => $user) :?>

    <?php 

      $firstname          = (isset($user['firstname'])) ? $user['firstname'] : "";
      $lastname           = (isset($user['lastname'])) ? $user['lastname'] : "";
      $name               =  $firstname." ".$lastname;
      $id                 = (isset($user['id'])) ? $user['id'] : "";
      $current_user_class = ($id == get_user_id()) ? "current-user" : "";
      $new_user           = (!$user['is_admin'])  ? " - ny älg 🥳 " : "";
    
    ?>

    <li class="<?=$current_user_class;?>">
      <a href="team/<?=escape_html($id);?>">
        <?=$name;?>
      </a>
      <?=$new_user;?>
    </li>  
  <?php endforeach; ?>
</ul>