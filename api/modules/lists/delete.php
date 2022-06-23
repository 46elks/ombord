<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Remove list
   *
   * @param $list_id (int) - required
   *
   * @return 
   *
   */

  function lists__delete($list_id){
    
    $params = ['list_id' => $list_id, 'is_deleted' => 1];

    $sql =<<< SQL
      UPDATE lists
      SET is_deleted = :is_deleted
      WHERE lists.id = :list_id
SQL;

    return db__update($sql, $params);
  }
