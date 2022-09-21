<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Add new user
   *
   * @param $list_id (int) - required
   * @param $user_id (int) - required
   *
   * @return int (id of row) or false
   *
   */

  function user__add($email, $password = null, $fileds = []){

    if(empty($email)) :
      debug__log("Unable to add user to due to missing user email");
      api__response(400, "Missing email");
    endif;

    $password_salt  = md5(time().uniqid());
    $api_user   = md5(time().uniqid());
    $api_secret = md5(time().uniqid());

    $params = [
      'email' => $email, 
      'api_user' => $api_user,
      'api_secret' => $api_secret,
      'password_salt' => $password_salt,
    ];

    $columns  = "email, api_user, api_secret, password_salt";
    $values   = ":email, :api_user, :api_secret, :password_salt";

    if(!empty($password)) :
      $password_hash = password_hash($password, PASSWORD_BCRYPT);
      $params['password_hash'] = $password_hash;
      $params['is_activated'] = 1;
      $columns  .= ", password_hash, is_activated";
      $values   .= ", :password_hash, :is_activated";
    endif;

    $sql =<<< SQL
      INSERT INTO users ($columns)
      VALUES ($values)
        ON DUPLICATE KEY UPDATE email = :email
        ;
SQL;
    
    return db__insert($sql, $params);
  }