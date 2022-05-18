<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Remove task
   *
   * @param $task_id (int) - required
   *
   * @return 
   *
   */

  function tasks__delete($task_id){
    
    $params = ['task_id' => $task_id, 'is_deleted' => 1];

    $sql =<<< SQL
      UPDATE tasks
      SET is_deleted = :is_deleted
      WHERE tasks.id = :task_id
    SQL;  

    return db__update($sql, $params);
  }
