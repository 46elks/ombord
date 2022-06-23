<?php

  /* -------------------------------
   ------------------------------- */

  /**
   * Select all task ids that belongs to the user
   * 
   * @param $user_id (int)
   * 
   * @return array 
   * 
   */

    function user_tasks__get($user_id){

      if(empty($user_id)):
        debug__log("Unable to retrieve user tasks due to missing user id");
        api__response(400, "Missing user id");
      endif;

      // Select tasks based on user_tasks
      // $sql =<<< SQL
      // SELECT GROUP_CONCAT(DISTINCT t.id) AS id
      //   FROM tasks t
      //   JOIN user_tasks AS ut
      //     ON ut.task_id = t.id
      //   WHERE ut.user_id = :user_id
      //     AND t.is_deleted = 0 
      //     AND ut.is_deleted = 0
      // SQL;

      // Select tasks based on user_lists and list_tasks
      $sql =<<< SQL
        SELECT GROUP_CONCAT(DISTINCT t.id) AS id
        FROM tasks t
        JOIN user_lists AS ul
          ON ul.user_id = :user_id
        JOIN list_tasks AS lt
          ON lt.list_id = ul.list_id
        WHERE t.is_deleted = 0 
          AND ul.is_deleted = 0
          AND lt.is_deleted = 0;
SQL;

      $params = ['user_id' => (int)$user_id];
      $results = db__select($sql, $params);
      if(isset($results[0]['id'])):
        return explode(",",$results[0]['id']);
      else:
        return [];
      endif;

    }
