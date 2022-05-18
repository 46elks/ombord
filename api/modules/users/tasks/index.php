<?php 

header("Access-Control-Allow-Methods: GET");

// Ensure request is authenticated
api__is_authenticated();

switch(strtoupper($_SERVER['REQUEST_METHOD'])):
  
  case "POST":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not supported");
    // // Include module functions
    // require_once("add.php");

    // // Get data from request
    // extract(api__request_data());
    
    // // Add new record
    // if(!isset($user_id)) $user_id = get_user_id();
    // if(!isset($task_id)) $task_id = null;
    // $results = user_tasks__add($user_id, $task_id);

    // // Send response
    // api__response(200, $results);
    break;

  case "GET":

    // Include module functions
    require_once("get.php");

    // Get data from request
    extract(api__request_data());
    
    // Get data
    $results = user_tasks__get(get_user_id());

    // Send response
    api__response(200, $results);

    break;
  
  case "PATCH":
  case "PUT":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not supported");

  case "DELETE":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not supported");
  break;

endswitch;