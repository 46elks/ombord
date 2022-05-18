<?php 

header("Access-Control-Allow-Methods: POST,GET, PATCH");

// Ensure request is authenticated
api__is_authenticated();

// Include module functions
switch(strtoupper($_SERVER['REQUEST_METHOD'])):
  
  case "POST":

    // Include module functions
    load_model("users","add");

    // Get data from request
    $data = api__request_data();
    $user_id = user__add($data['email'], $data['password']);

    unset($data['email']);
    unset($data['password']);

    // Update user
    if(!empty($data)):
      load_model("users","update");
      users__update($user_id,$data);
    endif;

    // Send response
    $results = ['id' => $user_id];
    api__response(200, $results);

    break;

  case "GET":

    // Include module functions
    load_model("users","get");

    // Get data from request
    extract(api__request_data());

    // Get data
    if(!isset($user_id)) $user_id = null;
    $results = user__get($user_id);

    // Send response
    api__response(200, $results);

    break;

  case "PATCH":
  
    // Include module functions
    load_model("users","update");

    // Get data from request
    $data = api__request_data();

    $user_id = $data['user_id'];
    unset($data['user_id']);

    if(empty($user_id)) :
      debug__log("Unable to update user due to missing user id");
      api__response(400, "Missing user id"); 
    elseif (empty($data)) :
      debug__log("Unable to update user due to missing fields");
      api__response(400, "Missing fields to update");
    endif;

    users__update($user_id, $data);
    api__response(200, "User updated");

    break;
  case "PUT":
  case "DELETE":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not supported");
  break;

endswitch;