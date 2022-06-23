<?php

  /* -------------------------------
   ------------------------------- */

  /**
   * Get user data from database
   * 
   * @param $user_id (int)
   * 
   * @return array 
   * 
   */

    function user__get($user_id){

      $params = [];
      $sql_where = "";
      $sql_limit = "";

      if(!empty($user_id)):
        $sql_where .= " AND u.id = :user_id";
        $params = ['user_id' => (int)$user_id];
        $sql_limit = " LIMIT 1";
      endif;
      
      $sql =<<< SQL
        SELECT 
          u.id, 
          u.firstname, 
          u.lastname, 
          u.email, 
          u.title, 
          u.description, 
          u.phone_work, 
          u.phone_private, 
          u.img,
          u.is_admin
        FROM users u
        WHERE u.is_deleted = 0 $sql_where
        $sql_limit
        ;
SQL;

      return db__select($sql, $params);

    }
