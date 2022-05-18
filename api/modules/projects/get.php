<?php

  /* -------------------------------
   ------------------------------- */

  /**
   * Get projects from database
   * 
   * @param $project_id (int) - optional
   * 
   * @return array
   * 
   */

    function projects__get($project_id = null){

      debug__log("Getting projects");

      if(empty($project_id)):
        $sql =<<< SQL
          SELECT p.id, p.title, p.name, p.description, p.is_template
            FROM projects p
            WHERE p.is_deleted = 0 
        SQL;
        $params = [];
      
      else:
        $sql =<<< SQL
        SELECT p.id, p.title, p.name, p.description, p.is_template
          FROM projects p
          WHERE p.id = :project_id
            AND p.is_deleted = 0 
        SQL;  

        $params = ['project_id' => (int)$project_id];

      endif;
      

      return db__select($sql, $params);

    }
