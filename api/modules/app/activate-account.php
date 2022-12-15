<?php 

header("Access-Control-Allow-Methods: POST");

if($_SERVER['REQUEST_METHOD']):

  $data = api__request_data();
  extract($data);

  if(!isset($password)) api__response(400,"Missing password");
  if(!isset($token)) api__response(400,"Missing token");

  load_model("sessions","get");
  $session = session__get("invite", $token);

  // Check if token is valid
  if(!isset($session[0])) api__response(400,"Token not found");

  extract($session[0]);

  if(time() > strtotime($expire_at)) api__response(400,"Invalid token");
  if($is_used) api__response(400,"Token is already used");

  // Set the new password and activate user account
  load_model("users","update");
  users__update($user_id,['password' => $password, 'is_activated' => 1]);

  // Disable the token to prevent it being used again
  load_model("sessions","update");
  session__update($token,'invite',['is_used' => 1]);

  $params  = ['user_id' => $user_id];
  $sql =<<< SQL
    SELECT 
      id,
      email,
      api_secret,
      api_user
    FROM users
    WHERE id = :user_id 
      AND is_deleted = 0
      AND is_activated = 1
    LIMIT 1;
SQL;

  $user = db__select($sql, $params);

  // Return response
  api__response(200, $user);

endif;