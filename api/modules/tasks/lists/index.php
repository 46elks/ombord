<?php 

header("Access-Control-Allow-Methods: GET");

// Ensure request is authenticated
api__is_authenticated();

switch(strtoupper($_SERVER['REQUEST_METHOD'])):
  
  case "POST":
    
    break;

  case "GET":

    // Get data from request
    extract(api__request_data());
    
    if(empty($id)):
      debug__log("Unable to retrieve task lists due to missing task id");
      api__response(400, "missing task id");
    endif;

    // Include module functions
    load_model("tasks/lists","get");
    $results = task_lists__get($id);
    
    // Send response
    api__response(200, $results);

    break;

  case "PATCH":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not supported");
    break;

  case "PUT":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not supported");
    break;
    
  case "DELETE":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not supported");
  break;

endswitch;