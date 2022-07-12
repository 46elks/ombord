<?php

  /* -------------------------------
   ------------------------------- */

  /**
   * Get all lists that a task is assigned to
   *
   * @param $id (int)
   *
   * @return array
   * 
   */

  function task_lists__get($id){

    $params = ['task_id' => $id]; 

      $sql =<<< SQL
        SELECT l.id, l.title, l.description, l.tasks_order
        FROM lists l
        JOIN list_tasks lt
          ON lt.list_id = l.id
        WHERE lt.task_id = :task_id
          AND l.is_deleted = 0
          AND lt.is_deleted = 0;
SQL;

    return db__select($sql, $params);
  }
