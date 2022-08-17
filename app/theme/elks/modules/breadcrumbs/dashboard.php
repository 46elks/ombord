<?php 
  
  // =======================================
  // Breadcrumb navigation for the dashboard
  // =======================================

  if(is_admin()) :
    $breadcrumbs = [
      ['title' => "Ombord"]
    ];
  else:
    $breadcrumbs = [
      ['title' => ""]
    ];
  endif;

 ?>