<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Get items from list
   *
   * @param $list_id (int) - required
   *
   * @return array
   *
   */

  function list_tasks__get($list_id){

    if(empty($list_id)) :
      debug__log("Unable to get items from list due to missing list id");
      api__response(400, "Missing list id");
    endif;
    
    $params = ['list_id' => $list_id];
    $sql =<<< SQL
      SELECT t.id, t.title, t.description, t.is_completed
      FROM tasks t
      LEFT JOIN list_tasks AS lt
        ON lt.task_id = t.id 
        AND lt.list_id = :list_id
      WHERE t.parent_id = 0
        AND t.is_deleted = 0 
        AND lt.is_deleted = 0;
    SQL;
    return db__select($sql, $params);
  }
