<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Remove project
   *
   * @param $project_id (int) - required
   *
   * @return 
   *
   */

  function projects__delete($project_id){
    
    $params = ['project_id' => $project_id, 'is_deleted' => 1];

    $sql =<<< SQL
      UPDATE projects
      SET is_deleted = :is_deleted
      WHERE projects.id = :project_id
SQL;

    return db__update($sql, $params);
  }
