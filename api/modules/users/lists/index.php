<?php 

header("Access-Control-Allow-Methods: POST,GET");

// Ensure request is authenticated
api__is_authenticated();

switch(strtoupper($_SERVER['REQUEST_METHOD'])):
  
  case "GET":

    // Include module functions
    load_model("users".DS."lists","get");

    // Get data from request
    extract(api__request_data());
    
    // Get data
    $results = user_lists__get(get_user_id());

    // Send response
    api__response(200, $results);

    break;

  case "POST":

    // Include module functions
    load_model("users".DS."lists","add");

    // Get data from request
    extract(api__request_data());

    // Get data
    if(empty($list_id)) :
      debug__log("Unable to add user to list due to missing list id");
      api__response(400, "Missing list id");
    elseif(empty($user_id)) :
      debug__log("Unable to add user to list due to missing user id");
      api__response(400, "Missing user id");
    endif;

    $results = user_lists__add($user_id, $list_id);

    // Send response
    api__response(200, $results);
    break;
  case "PATCH":
  case "PUT":
  case "DELETE":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not supported");
  break;

endswitch;