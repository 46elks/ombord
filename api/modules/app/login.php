<?php 

  header("Access-Control-Allow-Methods: POST");

  $email    = $_SERVER['PHP_AUTH_USER'];
  $password = $_SERVER['PHP_AUTH_PW'];

  if(!isset($email) || !isset($password)) api__response(401,"Missing password or username");

  $params  = ['email' => $email];
  $sql =<<< SQL
    SELECT 
      u.id,
      u.password_hash,
      u.api_secret,
      u.api_user
    FROM users u
    WHERE u.email = :email AND u.is_deleted = 0 
    LIMIT 1;
  SQL;

  $results = db__select($sql, $params);
  if(!isset($results[0])) api__response(401,"Wrong password or username");
  
  if(!password_verify($password, $results[0]['password_hash'])) api__response(401,"Wrong password or username");
  
  unset($results[0]['password_hash']);

  api__response(200, $results[0]);