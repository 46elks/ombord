<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Update existing task
   *
   * @param $task_id (int) - required
   * @param $fields (array) - required
   *
   */

  function tasks__update($task_id = null, $fields = []){
    
    extract($fields);
    
    $set = "";
    $params       = ['task_id' => $task_id];

    // Only allow these fields to be updated.
    $allowed_fields = ['title', 'description', 'is_completed', 'parent_id'];

    foreach ($fields as $key => $value) :
      
      if(!in_array($key, $allowed_fields)) continue;
      
      $set .= "$key = :{$key},";
      $params[$key] = $value;

      if($key === 'is_completed'):
        $set .= "completed_at = :completed_at,";
        if($value == 1):
          // The task is marked as completed.
          // Set a timestamp for when is was completed.
          $params['completed_at'] = date('Y-m-d H:i:s');
        else:
          // The task is marked a uncompleted.
          // Clear the timestamp får when it was completed.
          $params['completed_at'] = null;
        endif;
      endif;

    endforeach;

    // Remove last comma to prevent SQL error
    $set = rtrim($set, ',');

    $sql =<<< SQL
      UPDATE tasks as t
      SET $set
      WHERE t.id = :task_id AND t.is_deleted = 0;
    SQL;  

    return db__update($sql, $params);
  }
