<?php 

$error    = false;
$success  = false;
$message  = "";
$token    = (isset($_GET['token'])) ? $_GET['token'] : "";

if ($_SERVER['REQUEST_METHOD'] == "POST") :
  extract(process_password_reset($_POST));
  $success = !$error;
endif;

$view_data = [
  "success" => $success, 
  "error" => $error, 
  "message" => $message, 
  "token" => $token, 
];

?>
  
<?php ui__view_fragment("head.php");?>

<div class="outer-wrapper">
  <div class="inner-wrapper">
    <section id="reset-password">
      <?php if($token):
        ui__view_fragment("reset-password".DS."step-2-form.php", $view_data);
      else:
        ui__view_fragment("reset-password".DS."step-1-form.php", $view_data);
      endif;?>
    </section>
  </div>
</div>

<?php ui__view_fragment("foot.php");?>