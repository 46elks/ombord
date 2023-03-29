<?php 

  /* -------------------------------
   ------------------------------- */

  /**
   * Move a list to a different project
   *
   * @param $old_project_id (int) - required
   * @param $new_project_id (int) - required
   * @param $list_id (int) - required
   *
   * @return int (id of row) or false
   *
   */

  function projects_lists__move($old_project_id, $new_project_id, $list_id){

    $params = [
      'old_project_id' => $old_project_id, 
      'new_project_id' => $new_project_id, 
      'list_id' => $list_id
    ];

    $sql =<<< SQL
      UPDATE project_lists 
      SET project_id = :new_project_id
      WHERE project_id = :old_project_id AND list_id = :list_id
      ;
SQL;

    return db__update($sql, $params);
  }
