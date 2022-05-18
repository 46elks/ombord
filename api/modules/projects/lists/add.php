<?php 

  /* -------------------------------
   ------------------------------- */

  /**
   * Add list to project
   *
   * @param $project_id (int) - required
   * @param $list_id (int) - required
   *
   * @return int (id of row) or false
   *
   */

  function projects_lists__add($project_id, $list_id){

    if(empty($project_id)) :
      debug__log("Unable to add list to project due to missing project id");
      api__response(400, "Missing project id");
    elseif(empty($list_id)) :
      debug__log("Unable to add list to project due to missing list id");
      api__response(400, "Missing list id");
    endif;

    $params = ['project_id' => $project_id, 'list_id' => $list_id];

    $sql =<<< SQL
      INSERT INTO project_lists (project_id, list_id)
      VALUES (:project_id, :list_id)
        ON DUPLICATE KEY UPDATE is_deleted = 0;
    SQL;  

    return db__update($sql, $params);
  }
