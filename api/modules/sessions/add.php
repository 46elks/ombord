<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Add new session
   *
   * @param $type (string) - required
   * @param $user_id (int) - required
   * @param $expire (timestamp) - optional
   *
   * @return 
   *
   */

  function session__add($type, $token, $user_id, $expire = null){
    
    if(empty($type)) :
      debug__log("Unable to add session to due to missing type");
      api__response(400, "Missing type");
    elseif(empty($token)) :
      debug__log("Unable to add session to due to missing token");
      api__response(400, "Missing token");
    elseif(empty($user_id)) :
      debug__log("Unable to add session to due to missing user_id");
      api__response(400, "Missing field: user_id");
    endif;

    $params = ['type' => $type,'token' => $token, 'user_id' => $user_id];

    $columns  = "type, token, user_id";
    $values   = ":type, :token, :user_id";

    if(!empty($expire)) :
      $params['expire'] = $expire;
      $columns  .= ", expire_at";
      $values   .= ", :expire";
    endif;

    $sql = "INSERT INTO sessions ($columns) VALUES ($values)";
    
    return db__insert($sql, $params);
  }