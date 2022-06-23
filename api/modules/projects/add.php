<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Add new project
   *
   * @param $title (string) - required
   * @param $description (string) - optional
   *
   * @return int (id of row) or false
   *
   */

  function projects__add($name ="", $title = "", $description = "", $template = 0){

    $params  = [
      'name' => $name, 
      'title' => $title, 
      'description' => $description, 
      'is_template' => (int)$template
    ];

    $sql =<<< SQL
      INSERT INTO projects (name, title, description, is_template)
      VALUES (:name, :title, :description, :is_template);
SQL;

    return db__insert($sql, $params);
  }
