<?php


/**
 *  Create connection to database
 * 
 * 
 * @return obj
 * 
 */

function db__connect(){
  try {
      // PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'),
    $options = array(
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',
  );

    return new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS,$options);
  } catch (PDOExeption $error) {
    die($error->get_message());
  }
}


/**
 *  Close connection to database
 * 
 * 
 * @return nothing
 * 
 */

function db__close($conn){
  $conn = null;
}


/**
 * Select record from database
 * 
 * 
 * @return array
 * 
 */

function db__select($sql, $params = []){

  $conn   = db__connect();
  $query  = $conn->prepare($sql);

  if (!$query->execute($params)) :
    $errors = $query->errorInfo();
    debug__log("Error while retrieving data..");
    debug__log($errors);
    db__close($conn);
    api__response(500, "Error while proccessing your request");
  endif;

  $results = $query->fetchAll(PDO::FETCH_ASSOC);
  db__close($conn);
  return $results;

}


/**
 * Insert new record into database
 * 
 * 
 * @return int
 * 
 */

function db__insert($sql, $params = []){

  $conn   = db__connect();
  $query  = $conn->prepare($sql);

  if (!$query->execute($params)) :
    $errors = $query->errorInfo();
    debug__log("Error while inserting data..");
    debug__log($errors);
    db__close($conn);
    api__response(500, "Error while proccessing your request");
  endif;

  // Get the id of the new row
  $row_id = $conn->lastInsertId();
    
  if(empty($row_id)) :
    $error = $query->errorInfo();
    debug__log("Error while adding new record..");
    debug__log($error);
    api__response(400, "No record was added");
  endif;

  db__close($conn);
  return $row_id;

}


/**
 * Update record in database
 * 
 * 
 * @return int
 * 
 */

function db__update($sql, $params = []){

  $conn   = db__connect();
  $query  = $conn->prepare($sql);

  if (!$query->execute($params)) :
    $errors = $query->errorInfo();
    debug__log("Error while updating data..");
    debug__log($errors);
    db__close($conn);
    api__response(500, "Error while proccessing your request");
  endif;

  $affected_rows = $query->rowCount();
  db__close($conn);
  return $affected_rows;

}
