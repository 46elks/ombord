<?php 

  /* -------------------------------
   ------------------------------- */

  /**
   * Delete project from user
   *
   * @param $project_id (int) - required
   * @param $user_id (int) - required
   *
   * @return int (id of row) or false
   *
   */

  function users_projects__delete($user_id, $project_id){

    $params = ['project_id' => $project_id, 'user_id' => $user_id];

    $sql =<<< SQL
      DELETE FROM user_projects
      WHERE project_id = :project_id
        AND user_id = :user_id
      ;
SQL;

    return db__delete($sql, $params);
  }
