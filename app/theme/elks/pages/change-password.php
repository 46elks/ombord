<?php 

login_required();
$success    = false;
$error_msg  = "";

if (isset($_POST['password']) && isset($_POST['password_again'])):
  if($_POST['password'] !== $_POST['password_again']):
    $error_msg = "Lösenorden stämmer inte överrens. Försök igen";
  elseif(!password_is_valid($_POST['password'])) :
    $error_msg = "Lösenordet måste vara minst 8 tecken långt, innehålla minst en siffra, en stor och liten bokstav samt ett specialtecken.";
  else:
    $args = ['password' => $_POST['password'], 'user_id' => $_SESSION["user"]["id"]];
    if(!ui__api_patch("/users", $args, null, null)):
      $error_msg = 'Lösenordet blev inte uppdaterat. Försök igen.<br>';
      $error_msg .= 'Kontakta <a href="mailto:'.SYSTEM_ADMIN_EMAIL.'">admin</a> om felet kvarstår.';
    else:
      $success = true;
    endif;
  endif;

endif; ?>
  
<?php ui__view_fragment("head.php",['breadcrumbs' => ui__get_breadcrumbs("change-password")]); ;?>

<div class="outer-wrapper">
  <div class="inner-wrapper">
    <section id="change-password">
      <?php if($success): ?>
        <h1>Success 🥳</h1>
        <p class="preamble">Ditt lösenord har uppdaterats.</p>
      <?php else: ?>
      <h1>Ändra lösenord</h1>
      <?php if($error_msg): ?>
        <p class="notice--error"><?=$error_msg;?></p>
      <?php endif; ?>
      <form action="" method="post">
        <input type="password" required name="password" value="" placeholder="Ditt nya lösenord">
        <input type="password" required name="password_again" value="" placeholder="Upprepa ditt nya lösenord">
        <button type="submit" class="btn">Uppdatera</button>
      </form>
      <?php endif; ?>
    </section>
  </div>
</div>

<?php ui__view_fragment("foot.php");?>
