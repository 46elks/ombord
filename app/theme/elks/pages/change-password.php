<?php 

login_required();

$error    = false;
$success  = false;
$message  = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") :
  extract(reset_password($_POST));
  $success = !$error;
endif;?>
  
<?php ui__view_fragment("head.php",['breadcrumbs' => ui__get_breadcrumbs("change-password")]); ;?>

<div class="outer-wrapper">
  <div class="inner-wrapper">
    <section id="change-password">
      <?php if($success): ?>
        <h1>Success 🥳</h1>
        <p class="preamble">Ditt lösenord har uppdaterats.</p>
      <?php else: ?>
      <h1>Ändra lösenord</h1>
      <?php if($error): ?>
        <p class="notice--error"><?=$message;?></p>
      <?php endif; ?>
      <form action="" method="post">
        <input type="password" required name="password" value="" placeholder="Ditt nya lösenord">
        <input type="password" required name="password_again" value="" placeholder="Upprepa ditt nya lösenord">
        <input type="hidden" name="user_id" value="<?=$_SESSION["user"]["id"];?>">
        <button type="submit" class="btn">Uppdatera</button>
      </form>
      <?php endif; ?>
    </section>
  </div>
</div>

<?php ui__view_fragment("foot.php");?>
