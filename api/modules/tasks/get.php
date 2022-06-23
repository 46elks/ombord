<?php

  /* -------------------------------
   ------------------------------- */

  /**
   * Get tasks
   *
   * @param $task_id (int)
   * @param $user_id (int)
   *
   * @return array
   * 
   */

  function tasks__get($task_id, $get_subtasks = false){

    $params = ['task_id' => $task_id]; 

      $sql =<<< SQL
        SELECT t.id, t.title, t.description, t.is_completed
        FROM tasks t
        WHERE t.id = :task_id
          AND t.is_deleted = 0;
SQL;

    $tasks = db__select($sql, $params);
    
    if($get_subtasks):
      foreach ($tasks as $key => $task) :
        $task['subtasks'] = tasks__get__subtasks($task['id']);
        $tasks[$key] = $task;
      endforeach;
    endif;

    return $tasks;
  }

  /* -------------------------------
   ------------------------------- */

  /**
   * Get subtasks
   *
   * @param $task_id (int)
   *
   * @return array
   * 
   */

  function tasks__get__subtasks($task_id){

    if(empty($task_id)) return [];

    $params = ['task_id' => (int)$task_id];

      $sql =<<< SQL
        SELECT t.id, t.title, t.description, t.is_completed
        FROM tasks t
        WHERE parent_id = :task_id AND t.is_deleted = 0;
SQL;

    return db__select($sql, $params);
  }
