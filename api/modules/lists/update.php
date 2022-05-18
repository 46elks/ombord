<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Update existing list
   *
   * @param $list_id (int) - required
   * @param $fields (array) - required
   *
   */

  function lists__update($list_id, $fields){
    
    extract($fields);
    
    $set = "";
    $params       = ['list_id' => $list_id];

    // Only allow these fields to be updated.
    $allowed_fields = ['title', 'description', 'tasks_order'];

    foreach ($fields as $key => $value) :
      
      if(!in_array($key, $allowed_fields)) continue;
      
      $set .= "$key = :{$key},";
      $params[$key] = $value;
    endforeach;

    // Remove last comma to prevent SQL error
    $set = rtrim($set, ',');

    $sql =<<< SQL
      UPDATE lists as l
      SET $set
      WHERE l.id = :list_id AND l.is_deleted = 0;
    SQL;  

    return db__update($sql, $params);
  }
