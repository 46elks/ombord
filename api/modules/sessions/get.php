<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Get session
   *
   * @param $type (string) - required
   * @param $token (string) - required
   *
   * @return array
   *
   */

  function session__get($type, $token){
    
    if(empty($type)) :
      debug__log("Unable to get session to due to missing type");
      api__response(400, "Missing type");
    elseif(empty($token)) :
      debug__log("Unable to get session to due to missing token");
      api__response(400, "Missing token");
    endif;

    $params = ['type' => $type,'token' => $token];

    $sql =<<<SQL
      SELECT user_id, expire_at, is_used
      FROM sessions 
      WHERE type = :type AND token = :token
      LIMIT 1;
SQL;
    
    return db__select($sql, $params);
  }