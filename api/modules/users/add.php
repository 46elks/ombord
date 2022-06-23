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

  function user__add($email, $password, $fileds = []){

    if(empty($email)) :
      debug__log("Unable to add user to due to missing user email");
      api__response(400, "Missing email");
    elseif(empty($password)) :
      debug__log("Unable to add user to due to missing user password");
      api__response(400, "Missing user password");
    endif;

    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $api_user   = md5(time().uniqid());
    $api_secret = md5(time().uniqid());

    $params = [
      'email' => $email, 
      'password_hash' => $password_hash, 
      'api_user' => $api_user,
      'api_secret' => $api_secret,
    ];

    $sql =<<< SQL
      INSERT INTO users (email, password_hash, api_user, api_secret)
      VALUES (:email, :password_hash, :api_user, :api_secret)
        ON DUPLICATE KEY UPDATE email = :email
        ;
SQL;

    return db__insert($sql, $params);
  }