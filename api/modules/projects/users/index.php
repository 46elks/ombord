<?php 

header("Access-Control-Allow-Methods: GET");

// Ensure request is authenticated
api__is_authenticated();

switch(strtoupper($_SERVER['REQUEST_METHOD'])):
  
  case "POST":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not supported");
    break;
    
  case "GET":

    // Get data from request
    $data = api__request_data();
    extract($data);

    if(!isset($project_id)) {
      debug__log("Unable to retrieve users that belongs to the project due to missing project id. ".json_decode($data));
      api__response(400, "Missing project id");
    }

    load_model("projects".DS."users","get");
    $results = projects_users__get($project_id);
    
    api__response(200, $results);

    break;

  case "PUT":
  case "PATCH":
  case "DELETE":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not supported");
    break;
    
endswitch;