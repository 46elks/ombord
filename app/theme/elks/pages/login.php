<?php 

// Redirect user to dashboard if already logged in
if (is_logged_in()) header("Location: /dashboard");

if (isset($_POST['email']) && isset($_POST['password'])):
  
  // Login user  
  $user_obj = ui__api_post("/app/login", [], $_POST['email'], $_POST['password']);
  if($user_obj == null):
    echo "Felaktiga inloggnigsuppfigter";    
  else:
    set_session_user_data($user_obj);
    // Redirect to dashboard on sucessfull login
    header("Location: /dashboard");
  endif;

else: ?>

<?php ui__view_fragment("head.php");?>

<div class="outer-wrapper">
  <div class="inner-wrapper">
    <section id="login">
      <h1>Kom ombord</h1>
      <br>
      <form action="" method="post">
        <input type="text" name="email" placeholder="E-postadress" value="">
        <input type="password" name="password" value="" placeholder="Lösenord">
        <button type="submit" class="btn">Logga in</button>
      </form>
    </section>
  </div>
</div>

<?php ui__view_fragment("foot.php");?>
<?php endif; ?>