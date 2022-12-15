<?php 

header("Access-Control-Allow-Methods: POST, GET");

// Ensure request is authenticated
api__is_authenticated();

switch(strtoupper($_SERVER['REQUEST_METHOD'])):
  
  // Reset password
  case "POST":
    $data = api__request_data();

    extract($data);

    if(!isset($password)) api__response(400,"Missing password");
    

    if(isset($user_id)):

      // Set the new password
      load_model("users","update");
      users__update($user_id,['password' => $password]);

      // Return response
      api__response(200, "Password updated");

    elseif(!isset($token)):
      api__response(400,"Missing token");
    endif;
    

    load_model("sessions","get");
    $results = session__get("reset-password", $token);

    // Check if token is valid
    if(!isset($results[0])) api__response(400,"Token not found");

    extract($results[0]);

    if(time() > strtotime($expire_at)) api__response(400,"Invalid token");
    if($is_used) api__response(400,"Token is already used");

    // Set the new password
    load_model("users","update");
    users__update($user_id,['password' => $password]);

    // Disable the token to prevent it being used again
    load_model("sessions","update");
    session__update($token,'reset-password',['is_used' => 1]);

    // Return response
    api__response(200, "Password updated");

  break;

  // Find user and create a reset link
  case "GET":

    $data = api__request_data();
    $email = isset($data['email']) ? $data['email'] : null;
    
    // Get user    
    $sql =<<< SQL
      SELECT 
        u.id, 
        u.password_salt AS "salt"
      FROM users u
      WHERE u.is_deleted = 0 and u.email = :email
      LIMIT 1;
SQL;

      $user = db__select($sql, ['email' => $email]);

      if(empty($user)) api__response(404, "No user found");
        
      extract($user[0]);

      $time   = time();
      $now    = date("Y-m-d H:i:s", $time);
      $token  = sha1($email.$salt.$now);
      $expire = date("Y-m-d H:i:s", $time + (60*10)); // Expire after 10 minutes
      $type   = "reset-password";

      load_model("sessions","add");
      session__add($type, $token, $id, $expire);

      // Send response
      api__response(200, ['token' => $token]);

    break;

endswitch;
