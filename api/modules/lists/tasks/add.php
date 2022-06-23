<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Add task to list
   *
   * @param $list_id (int) - required
   * @param $task_id (int) - required
   *
   * @return int (id of row) or false
   *
   */

  function list_tasks__add($list_id, $task_id){

    if(empty($list_id)) :
      debug__log("Unable to add task to list due to missing list id");
      api__response(400, "Missing list id");
    elseif(empty($task_id)) :
      debug__log("Unable to add task to list due to missing task id");
      api__response(400, "Missing task id");
    endif;

    $params = ['list_id' => $list_id, 'task_id' => $task_id];

    $sql =<<< SQL
      INSERT INTO list_tasks (list_id, task_id)
      VALUES (:list_id, :task_id)
        ON DUPLICATE KEY UPDATE is_deleted = 0;
SQL;

    return db__update($sql, $params);
  }
