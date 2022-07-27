<?php 

login_required();

$filename = basename($_SERVER["REQUEST_URI"]);
$path = UPLOAD_PATH.DS.$filename;

if(!file_exists($path)) {
  ui__view_page("error-404.php");
} else{
  header('X-Sendfile: '.$path);
  header('Content-type: image/jpeg');
  header('Content-Disposition: inline; filename="'.$filename.'"');
  readfile($path);
}