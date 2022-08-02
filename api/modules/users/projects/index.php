<?php 

header("Access-Control-Allow-Methods: POST,DELETE");

// Ensure request is authenticated
api__is_authenticated();

// Include module functions
switch(strtoupper($_SERVER['REQUEST_METHOD'])):
  
  case "POST":

    // Include module functions
    load_model("users".DS."projects","add");

    // Get data from request
    $data = api__request_data();
    extract($data);
    
    if(empty($user_id)) {
      debug__log("Unable to add project to user due to missing user id. ".json_decode($data));
      api__response(400, "Missing user id");
    }
    if(empty($project_id)) {
      debug__log("Unable to add project to user due to missing project id. ".json_decode($data));
      api__response(400, "Missing project id");
    }
    
    users_projects__add($user_id,$project_id);
    
    // Send response
    api__response(200, "Project added to user");

    break;

  case "GET":
  case "PATCH":
  case "PUT":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not supported");
    break;

  case "DELETE":
    
    // Include module functions
    load_model("users".DS."projects","delete");

    // Get data from request
    $data = api__request_data();
    extract($data);
    
    if(empty($user_id)) {
      debug__log("Unable to remove project from user due to missing user id. ".json_encode($data));
      api__response(400, "Missing user id");
    }
    if(empty($project_id)) {
      debug__log("Unable to remove project from unser due to missing project id. ".json_encode($data));
      api__response(400, "Missing project id");
    }
    
    users_projects__delete($user_id,$project_id);
    
    // Send response
    api__response(200, "Project removed from user");
    break;

endswitch;