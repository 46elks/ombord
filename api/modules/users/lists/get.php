<?php

  /* -------------------------------
   ------------------------------- */

  /**
   * Select all list ids that belongs to the user
   * 
   * @param $user_id (int)
   * 
   * @return array 
   * 
   */

    function user_lists__get($user_id){

      if(empty($user_id)):
        debug__log("Unable to retrieve user list due to missing user id");
        api__response(400, "Missing user id");
      endif;

      $sql =<<< SQL
      SELECT GROUP_CONCAT(DISTINCT l.id) AS id
        FROM lists l
        JOIN user_lists AS ul 
          ON ul.list_id = l.id
        WHERE ul.user_id = :user_id
          AND l.is_deleted = 0 
          AND ul.is_deleted = 0
SQL;

      $params = ['user_id' => (int)$user_id];
      $results = db__select($sql, $params);
      if(isset($results[0]['id'])):
        return explode(",",$results[0]['id']);
      else:
        return [];
      endif;

    }
