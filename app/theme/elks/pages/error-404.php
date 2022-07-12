<?php 
  ui__view_fragment("head.php",['breadcrumbs' => ui__get_breadcrumbs("error")]);
?>
<div class="outer-wrapper">
  <div class="inner-wrapper">
    <h1>🤥 404</h1>
    <p class="preamble">Hoppsan.. här finns det ingenting.</p>
  </div>
</div>
<?php ui__view_fragment("foot.php");?>
<?php exit(); ?>