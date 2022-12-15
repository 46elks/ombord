<?php 

$error    = false;
$success  = false;
$message  = "";
$token = (isset($_GET['token'])) ? $_GET['token'] : "";

if(empty($token)) header("Location: /login");

if ($_SERVER['REQUEST_METHOD'] == "POST") :
  extract(process_account_activation($_POST));
  $success = !$error;
endif;

?>

<?php ui__view_fragment("head.php");?>

<div class="outer-wrapper">
  <div class="inner-wrapper">
    <section id="activate-account">
      <h1>Aktivera ditt konto</h1>
      <?php if($error): ?>
        <p class="notice--error"><?=$message;?></p>
      <?php endif; ?>
      <form action="" method="post">
        <input type="password" required name="password" value="" placeholder="Ange ditt nya lösenord">
        <input type="password" required name="password_again" value="" placeholder="Ange ditt lösenord igen">
        <input type="hidden" name="token" value="<?=htmlspecialchars($token);?>">
        <button type="submit" class="btn">Aktivera</button>
      </form>
    </section>
  </div>
</div>

<?php ui__view_fragment("foot.php");?>
