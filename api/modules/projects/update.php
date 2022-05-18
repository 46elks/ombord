<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Update existing project (PATCH/PUT)
   *
   * @param $project_id (int) - required
   * @param $fields (array) - required
   *
   */

  function projects__update($project_id, $fields){
    
    if(empty($fields)) return false;
    
    extract($fields);
    
    $set = "";
    $params       = ['project_id' => $project_id];

    // Only allow these fields to be updated.
    $allowed_fields = ['title', 'description', 'is_template', 'name'];

    foreach ($fields as $key => $value) :
      
      if(!in_array($key, $allowed_fields)) continue;
      
      $set .= "$key = :{$key},";
      $params[$key] = $value;
    endforeach;

    // Remove last comma to prevent SQL error
    $set = rtrim($set, ',');

    $sql =<<< SQL
      UPDATE projects
      SET $set
      WHERE id = :project_id AND is_deleted = 0;
    SQL;  

    return db__update($sql, $params);
  }
