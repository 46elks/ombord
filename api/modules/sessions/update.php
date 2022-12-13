<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Update session
   *
   * @param $type (string) - required
   * @param $token (string) - required
   * @param $fields (array) - required
   *
   * @return array
   *
   */

  function session__update($token, $type, $fields = []){
    
    if(empty($type)) :
      debug__log("Unable to update session to due to missing type");
      api__response(400, "Missing type");
    elseif(empty($token)) :
      debug__log("Unable to update session to due to missing token");
      api__response(400, "Missing token");
    endif;

    $params = ['type' => $type,'token' => $token];

     // Only allow these fields to be updated.
    $allowed_fields = ['expire_at', 'is_used'];
    $set = "";
    foreach ($fields as $key => $value) :
      
      if(!in_array($key, $allowed_fields)) continue;
      
      $set .= "$key = :{$key},";
      $params[$key] = $value;

    endforeach;

    // Remove last comma to prevent SQL error
    $set = rtrim($set, ',');

    if(empty($set)) :
      debug__log("Unable to update session. No valid data provided.");
      api__response(400, "No valid data provided"); 
    endif;

    $sql =<<<SQL
      UPDATE sessions
      SET $set
      WHERE type = :type AND token = :token
      LIMIT 1;
SQL;
    
    return db__update($sql, $params);
  }