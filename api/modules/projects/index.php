<?php 

header("Access-Control-Allow-Methods: POST,GET,PATCH");

// Ensure request is authenticated
api__is_authenticated();

switch(strtoupper($_SERVER['REQUEST_METHOD'])):
  
  case "POST":

    // Get data from request
    extract(api__request_data());

    if (isset($project_id)) :
      // Copy a project from template

      // Include module functions
      require_once("copy.php");
      $title = (isset($title)) ? $title : null;
      $description = (isset($description)) ? $description : null;
      $name = (isset($name)) ? $name : null;
      $project_id = projects__copy($project_id,$name,$title,$description);
      
    else:

      // Include module functions
      require_once("add.php");

      if (!isset($title)) $title = null;
      if (!isset($description)) $description = null;
      if (!isset($is_template)) $is_template = null;
      if (!isset($name)) $name = null;

      // Create new project
      $project_id = projects__add($name,$title,$description,$is_template);

    endif;

    // Add project to user
    if(isset($user_id) && !empty($project_id)):
      load_model("users".DS."projects","add");
      users_projects__add($user_id,$project_id);
    endif;

    // Send response
    api__response(200, ['id' => $project_id]);
    
    break;
    
  case "GET":

    // Get data from request
    extract(api__request_data());

    if(isset($user_id)):
      load_model("users".DS."projects","get");
      $results = users_projects__get($user_id);
    else:
      load_model("projects","get");
      if(!isset($project_id)) $project_id = null;
      $results = projects__get($project_id);
    endif;
    
    api__response(200, $results);

    break;

  case "PUT":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not yet supported");
    break;

  case "PATCH":
     
    // Include module functions
    load_model("projects","update");

    $data     = api__request_data();

    if(empty($data['project_id'])) :
      debug__log("Unable to update project due to missing project id");
      api__response(400, "Missing project id");
    endif;

    $project_id = $data['project_id'];
    unset($data['project_id']);

    if (empty($data)) :
      debug__log("Unable to update project due to missing fields");
      api__response(400, "Missing project fields to update");
    endif;

    // Add user to project
    if(isset($data['user_id'])) :
      load_model("users".DS."projects","add");
      users_projects__add($data['user_id'], $project_id);
      unset($data['user_id']);
    endif;
    
    if(!empty($data)) :
      projects__update($project_id, $data);
    endif;

    api__response(200, "Project updated");

    break;
  case "DELETE":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not yet supported");
    break;
    
endswitch;