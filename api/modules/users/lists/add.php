<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Add list to user
   *
   * @param $list_id (int) - required
   * @param $user_id (int) - required
   *
   * @return int (id of row) or false
   *
   */

  function user_lists__add($user_id, $list_id){

    $params = ['list_id' => $list_id, 'user_id' => $user_id];

    $sql =<<< SQL
      INSERT INTO user_lists (list_id, user_id)
      VALUES (:list_id, :user_id)
        ON DUPLICATE KEY UPDATE is_deleted = 0;
SQL;

    return db__update($sql, $params);
  }
