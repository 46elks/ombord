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
    $email    = isset($data['email']) ? $data['email'] : null;
    $password = isset($data['password']) ? $data['password'] : null;
      
    $response = array();

    // Add user
    $user_id = user__add($email, $password);
    $response['id'] = $user_id;

    if($email) unset($data['email']);
    if($password) unset($data['password']);

    // Generate an invite token if no password was set
    if(!$password):

      $sql        = 'SELECT email, password_salt AS "salt" FROM users WHERE id = :user_id LIMIT 1';
      $params     = ['user_id' => $user_id];
      $user_data  = db__select($sql, $params);

      if(!empty($user_data[0])):

        extract($user_data[0]);
        $time   = time();
        $now    = date("Y-m-d H:i:s", $time);
        $token  = sha1($email.$salt.$now);
        $expire = date("Y-m-d H:i:s", $time + 604800); // Expire after 7 days
        $type   = "invite";

        load_model("sessions","add");
        session__add($type, $token, $user_id, $expire);

        $response['token'] = $token;

      endif;

    endif;

    // Update user if there are any data to be updated
    if(!empty($data)):
      load_model("users","update");
      users__update($user_id,$data);
    endif;

    // Send response
    api__response(200, $response);

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