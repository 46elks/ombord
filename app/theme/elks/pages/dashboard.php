<?php 
  login_required();
  ui__view_fragment("head.php",['breadcrumbs' => ui__get_breadcrumbs("dashboard")]); 
?>

<div class="outer-wrapper">
  <div class="inner-wrapper">
    <?php
    if (is_admin()) :
      ui__view_fragment("dashboard-admin.php");
    else:
      ui__view_fragment("dashboard-new-user.php");
    endif;
    ?>
  </div>
</div>

<?php ui__view_fragment("foot.php");  ?>