<?php

  /* -------------------------------
   ------------------------------- */

  /**
   * Get a list of users that belongs to a specific project
   * 
   * @param $project_id (int) - required
   * 
   * @return array
   * 
   */

  function projects_users__get($project_id){

    debug__log("Getting project users");

    $sql =<<< SQL
      SELECT u.id, u.firstname, u.lastname, u.title, u.img, u.is_admin
        FROM users u
        INNER JOIN user_projects up
          ON up.project_id = :project_id
        WHERE up.user_id = u.id
          AND up.is_deleted = 0;
SQL;

    $params = ['project_id' => (int)$project_id];

    return db__select($sql, $params);

  }
