<?php 

  header("Access-Control-Allow-Methods: POST");

  $password = $_POST['password'];
  $hash     = $_POST['hash'];

  if(!isset($hash) || !isset($password)) api__response(401,"Missing password or hash");

  $params  = ['hash' => $hash];
  $sql =<<< SQL
    SELECT 
      id,
      email,
      password_salt,
      api_secret,
      api_user
    FROM users
    WHERE password_hash = :hash 
      AND is_deleted = 0
      AND is_activated = 0
    LIMIT 1;
SQL;

  $results = db__select($sql, $params);

  // Check if hash is valid
  extract($results[0]);
  if(!isset($results[0])) api__response(401,"Invalid activation code");
  if($hash != generate_activation_hash($email,$password_salt)) api__response(401,"Invalid activation code");

  // Set the new password
  load_model("users","update");
  users__update($id,['password' => $password, 'is_activated' => 1]);

  // Return response
  unset($results[0]['email']);
  unset($results[0]['password_salt']);

  api__response(200, $results[0]);