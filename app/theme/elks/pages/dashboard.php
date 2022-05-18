<?php 
  login_required();
  $head_data = [
    'breadcrumbs' =>[
      ['title' => "Ombord", 'url' => "/dashboard"],
    ]
  ];

  ui__view_fragment("head.php", $head_data); 
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