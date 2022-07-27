<?php 
header("Content-type:multipart/form-data");
header("Content-type:application/json");
login_required();

if(!isset($_POST['_action'])) {
  http_response_code(400);
  echo json_encode("No action found");
  exit();
}

switch ($_POST['_action']) {
  case 'UPLOAD_ATTACHMENT':

    $target_dir     = ROOT.DIRECTORY_SEPARATOR."uploads";
    $file           = $_FILES['files'];
    $path_parts     = pathinfo($file["name"][0]);
    $file_type      = $path_parts['extension'];
    $file_name      = md5($path_parts['filename'].time()).".".$file_type;
    $target_file    = $target_dir.DIRECTORY_SEPARATOR.$file_name;
    $image_src      = "/uploads/".$file_name;
    $file_size      = $file['size'][0];
    $file_tmp_name  = $file['tmp_name'][0];
    $is_error       = 0;

    // Create the upload directory if it not already exists
    if(!file_exists($target_dir)) mkdir($target_dir,0755,true);
    
    // Check if image file is a actual image or fake image
    $file_data = getimagesize($file_tmp_name);
    if(!$file_data) :
      response(400,"The file is not an image or the image format is not supported.");
      $is_error = 1;
    endif;

    // Check if file already exists
    if (file_exists($target_file)) {
      response(400,"Sorry, file already exists.");
      $is_error = 1;
    }

    // Check file size (max 5 MB)
    if ($file_size > 5000000) {
      response(400,"Sorry, your file is too large. Allowed maximum size is 5 MB");
      $is_error = 1;
    }

    // Allow certain file formats
    $allowed_file_types = ["jpg","jpeg","png","gif","image/jpg","image/jpeg","image/png","image/gif"];
    if(!in_array(strtolower($file_data["mime"]), $allowed_file_types)) {
      response(400,"Sorry, only JPG, JPEG, PNG & GIF files are allowed.");
      $is_error = 1;
    }

    // Check if there is any errors
    if ($is_error) :
      response(400,"Sorry, your file was not uploaded.");
    endif;

    // Try to upload file
    if (!move_uploaded_file($file_tmp_name, $target_file)) :
      response(400,"Sorry, there was an error uploading your file.");
    endif;

    $response = [
      'href'=> $image_src,
      'url'=> $image_src
    ];
    response(200,$response);
    break;
  
  default:
    response(400,"No action found");
    break;
}


function response($status,$data){
  http_response_code($status);
  echo json_encode($data);
  exit();
}
?>