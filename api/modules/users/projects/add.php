<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Add project to user
   *
   * @param $project_id (int) - required
   * @param $user_id (int) - required
   *
   * @return int (id of row) or false
   *
   */

  function users_projects__add($user_id, $project_id){

    $params = ['project_id' => $project_id, 'user_id' => $user_id];

    $sql =<<< SQL
      INSERT INTO user_projects (project_id, user_id)
      VALUES (:project_id, :user_id)
        ON DUPLICATE KEY UPDATE is_deleted = 0;
    SQL;  

    return db__insert($sql, $params);
  }
