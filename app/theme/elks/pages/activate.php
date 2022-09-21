<?php 

$error = "";
$hash = (isset($_GET['hash'])) ? $_GET['hash'] : "";

if(empty($hash)) header("Location: /login");

if (isset($_POST['password']) && isset($_POST['password_again'])):

  if($_POST['password'] !== $_POST['password_again']):
    // Check if the passwords match
    $error = "Lösenorden stämmer inte överrens. Försök igen";
  elseif(strlen($_POST['password']) < 8):
    $error = "Lösenordet måste vara minst 8 tecken långt";
  else:

    // Activate user  
    $user_obj = null;
    extract($_POST);
    $user_obj = ui__api_post("/app/activate-account", ['password' => $password, 'hash' => $hash], null, null);
    if($user_obj == null):
      $error = "Aktiveringen misslyckades.<br>Antingen så finns inte användaren eller så är aktiveringskoden ogiltig.";
    else:
      set_session_user_data($user_obj);
      // Redirect to dashboard on sucessfull login
      header("Location: /dashboard");
    endif;
  endif;


endif; ?>

<?php ui__view_fragment("head.php");?>

<div class="outer-wrapper">
  <div class="inner-wrapper">
    <section id="activate-account">
      <h1>Aktivera ditt konto</h1>
      <?php if($error): ?>
        <p class="notice--error"><?=$error;?></p>
      <?php endif; ?>
      <form action="" method="post">
        <input type="password" required name="password" value="" placeholder="Ange ditt nya lösenord">
        <input type="password" required name="password_again" value="" placeholder="Ange ditt lösenord igen">
        <input type="hidden" name="hash" value="<?=htmlspecialchars($_GET['hash']);?>">
        <button type="submit" class="btn">Aktivera</button>
      </form>
    </section>
  </div>
</div>

<?php ui__view_fragment("foot.php");?>
