<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Add new task
   *
   * @param $title (string) - required
   * @param $description (string) - optional
   * @param $parent_id (int) - optional
   *
   * @return int (id of row) or false
   *
   */

  function tasks__add($title, $description = "", $parent_id = 0){
   
    $title        = $title;
    $description  = $description;
    $parent_id    = $parent_id;

    $params       = ['title' => $title, 'description' => $description, 'parent_id' => (int)$parent_id];

    $sql =<<< SQL
      INSERT INTO tasks (title, description, parent_id)
      VALUES (:title, :description, :parent_id);
SQL;

    return db__insert($sql, $params);
  }