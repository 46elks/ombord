<?php

  /* -------------------------------
   ------------------------------- */

  /**
   * Get lists from database
   * 
   * @param $list_id (int)
   * 
   * @return array
   * 
   */

    function lists__get($list_id){

      debug__log("Getting lists");

      if(empty($list_id)):
        debug__log("Unable to retrieve lists due to missing list id");
        api__response(400, "missing list id");
      endif;

      $sql =<<< SQL
      SELECT l.id, l.title, l.description, l.tasks_order
        FROM lists l
        WHERE l.id = :list_id
          AND l.is_deleted = 0;
      SQL;  

      $params = ['list_id' => (int)$list_id];

      return db__select($sql, $params);

    }
