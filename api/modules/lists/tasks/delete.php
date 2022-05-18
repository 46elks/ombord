<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Remove task from list
   *
   * @param $list_id (int) - required
   * @param $task_id (int) - required
   *
   * @return int (id of row) or false
   *
   */

  function list_tasks__delete($list_id, $task_id){

    if(empty($id)) :
      debug__log("Unable to remove task from list due to missing list id");
      api__response(400, "Missing list id");
    elseif(empty($task_id)) :
      debug__log("Unable to remove task from list due to missing task id");
      api__response(400, "Missing task id");
    endif;
    
    $params = ['list_id' => $list_id, 'task_id' => $task_id, 'is_deleted' => 1];

    $sql =<<< SQL
      UPDATE list_tasks
      SET is_deleted = :is_deleted
      WHERE list_tasks.list_id = :list_id AND list_tasks.task_id = :task_id 
    SQL;  

    return db__update($sql, $params);
  }
