<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Update existing user
   *
   * @param $user_id (int) - required
   * @param $fields (array) - required
   *
   */

  function users__update($user_id, $fields = []){
  
    $set = "";
    $params       = ['user_id' => $user_id];

    if(isset($fields['password']) && !empty($fields['password'])):
      $fields['password_hash'] = get_hashed_password($fields['password']);
      unset($fields['password']);
    endif;

    // Only allow these fields to be updated.
    $allowed_fields = [
      'firstname', 
      'lastname', 
      'email', 
      'title', 
      'description', 
      'phone_work', 
      'phone_private', 
      'img',
      'is_admin',
      'password_hash',

      // 'api_user',
      // 'api_secret',
      // 'password_hash',
      // 'password_salt',
    ];

    foreach ($fields as $key => $value) :
      
      if(!in_array($key, $allowed_fields)) continue;
      
      $set .= "$key = :{$key},";
      $params[$key] = $value;

    endforeach;

    // Remove last comma to prevent SQL error
    $set = rtrim($set, ',');

    if(empty($set)) :
      debug__log("Unable to update user. No valid data provided.");
      api__response(400, "No vaild data provided"); 
    endif;

    $sql =<<< SQL
      UPDATE users as u
      SET $set
      WHERE u.id = :user_id AND u.is_deleted = 0;
    SQL;  
    return db__update($sql, $params);
  }
