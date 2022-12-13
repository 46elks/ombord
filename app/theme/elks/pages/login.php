<?php 

// Redirect user to dashboard if already logged in
if (is_logged_in()) header("Location: /dashboard");

$error = "";

if (isset($_POST['email']) && isset($_POST['password'])):
  
  // Login user  
  $user_obj = ui__api_post("/app/login", [], $_POST['email'], $_POST['password']);
  if($user_obj == null):
    $error = "Felaktiga inloggningsuppgifter";    
  else:
    set_session_user_data($user_obj);
    // Redirect to dashboard on sucessfull login
    header("Location: /dashboard");
  endif;

endif;?>

<?php ui__view_fragment("head.php");?>

<div class="outer-wrapper">
  <div class="inner-wrapper">
    <section id="login">
      <h1>Välkommen ombord</h1>
      <?php if($error): ?>
        <p class="notice--error"><?=$error;?></p>
      <?php endif; ?>
      <form action="" method="post">
        <input type="text" name="email" placeholder="E-postadress" value="<?=(isset($_POST['email'])) ? htmlentities($_POST['email']) : "";?>">
        <input type="password" name="password" value="" placeholder="Lösenord">
        <button type="submit" class="btn">Logga in</button>
      </form>
      <p><a href="/reset">Glömt lösenord?</a></p>
    </section>
  </div>
</div>

<?php ui__view_fragment("foot.php");?>
