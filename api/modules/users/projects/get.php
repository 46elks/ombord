<?php

  /* -------------------------------
   ------------------------------- */

  /**
   * Get projects from database
   * 
   * @param $project_id (int)
   * @param $user_id (int)
   * 
   * @return array
   * 
   */

    function users_projects__get($user_id){

      debug__log("Getting projects");

      if(empty($user_id)) :
        debug__log("Unable to retrieve user projects due to missing user id .");
        api__response(400, "Missing user id");
      endif;
      
      debug__log("Retreieve all projects for the user ".$user_id);
      
      // Select all projects that belongs to the user
      $sql =<<< SQL
      SELECT p.id, p.title, p.name, p.description, p.is_template
        FROM projects p
        JOIN user_projects AS up 
          ON up.project_id = p.id
        WHERE up.user_id = :user_id
          AND p.is_deleted = 0 
          AND up.is_deleted = 0
SQL;

      $params = ['user_id' => (int)$user_id];

      return db__select($sql, $params);

    }
