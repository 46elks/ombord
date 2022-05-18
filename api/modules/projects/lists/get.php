<?php

  /* -------------------------------
   ------------------------------- */

  /**
   * Get projects from database
   * 
   * @param $project_id (int)
   * 
   * @return array
   * 
   */

    function projects_lists__get($project_id){

      debug__log("Getting projects");

      if(empty($project_id)):
        debug__log("Unable to retrieve project lists due to missing project id");
        api__response(400, "missing project id");
      endif;

      // Select all lists that belongs to the project
      $sql =<<< SQL
      SELECT l.id, l.title, l.description, l.tasks_order
        FROM lists l
        JOIN project_lists AS pl 
          ON pl.list_id = l.id 
        WHERE pl.project_id = :project_id AND l.is_deleted = 0
      SQL;

      $params = ['project_id' => (int)$project_id];

      return db__select($sql, $params);

    }
