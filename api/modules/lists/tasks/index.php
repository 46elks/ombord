<?php 

header("Access-Control-Allow-Methods: POST,DELETE,GET");

// Ensure request is authenticated
api__is_authenticated();

switch(strtoupper($_SERVER['REQUEST_METHOD'])):
  
  case "POST":

    // Include module functions
    load_model("lists".DS."tasks","add");  

    // Get data from request
    extract(api__request_data());
    
    // Add task to list
    if (!isset($list_id)) $list_id = null;
    if (!isset($task_id)) $task_id = null;
    $row_id = list_tasks__add($list_id, $task_id);

    // Send response
    api__response(200, "Task added to list");
    
    break;

  case "GET":

    // Include module functions
    load_model("lists".DS."tasks","get");

    // Get data from request
    extract(api__request_data());

    // Add task to list
    if (!isset($list_id)) $list_id = null;
    $results = list_tasks__get($list_id, get_user_id());

    // Send response
    api__response(200, $results);

    break;

  case "PUT":
  case "PATCH":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not supported");
  break;

  case "DELETE":
    
    // Include module functions
    load_model("lists".DS."tasks","delete");

    // Get data from request
    extract(api__request_data());
    
    // Add task to list
    if (!isset($list_id)) $list_id = null;
    if (!isset($task_id)) $task_id = null;
    list_tasks__delete($list_id, $task_id);

    // Send response
    api__response(200, "Task removed from list");

    break;

endswitch;