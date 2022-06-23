<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Add new list
   *
   * @param $title (string) - required
   * @param $description (string) - optional
   *
   * @return int (id of row) or false
   *
   */

  function lists__add($title, $description = ""){

    if (empty($title)) :
      debug__log("Unable to add list due to missing list title");
      api__response(400, "Missing list title");
    endif;
    
    $title        = (string)$title;
    $description  = (string)$description;

    $params       = ['title' => $title, 'description' => $description];

    $sql =<<< SQL
      INSERT INTO lists (title, description)
      VALUES (:title, :description);
SQL;

    return db__insert($sql, $params);
  }
