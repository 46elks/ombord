<?php


  /* -------------------------------
   ------------------------------- */

  /**
   * Add user premission to task
   *
   * @param $user_id (int) - required
   * @param $task_id (int) - required
   *
   * @return int
   *
   */
  
  function user_tasks__add($user_id, $task_id){

    $user_id = (int)$user_id;
    $task_id = (int)$task_id;

    if (empty($task_id)):
      debug__log("Unable to add user task due to missing task id");
      api__response(400, "Missing task id");
    elseif (empty($user_id)) :
      debug__log("Unable to add user task due to missing user id");
      api__response(400, "Missing user id");
    endif;

    $sql =<<< SQL
      INSERT INTO user_tasks (task_id, user_id) 
      VALUES (:task_id, :user_id)
      ON DUPLICATE KEY UPDATE is_deleted = 0;
    SQL;
    $params = array('task_id' => $task_id, 'user_id' => $user_id);
    
    return db__insert($sql, $params);
    
  }

