<?php 

header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");

// Ensure request is authenticated
api__is_authenticated();

switch(strtoupper($_SERVER['REQUEST_METHOD'])):
  
  case "POST":

    // Include module functions
    load_model("tasks","add");

    // Get data from request
    extract(api__request_data());

    if (empty($title)) :
      debug__log("Unable to add task due to missing task title");
      api__response(400, "Missing task title");
    elseif (empty($list_id)) :
      debug__log("Unable to add task due to missing list id");
      api__response(400, "Missing list id");
    endif;

    // if (!isset($title)) $title = null;
    if (!isset($description)) $description = null;
    if (!isset($parent_id)) $parent_id = null;

    // Add new task
    $task_id = tasks__add($title, $description, $parent_id);

    // Add task to list
    if(!empty($task_id)) :
      load_model("lists".DS."tasks","add");
      list_tasks__add($list_id, $task_id);
    endif;
    
    // Send response
    api__response(200, ['id' => $task_id]);
    
    break;

  case "GET":

    // Get data from request
    extract(api__request_data());
    
    if(isset($list_id)):
      // Include module functions
      load_model("lists".DS."tasks","get");      
      $results = list_tasks__get($list_id);
    else:

      if(empty($task_id)):
        debug__log("Unable to retrieve task due to missing task id");
        api__response(400, "missing task id");
      endif;

      // Include module functions
      load_model("tasks","get");
      if(!isset($get_subtasks)) $get_subtasks = false;
      $results = tasks__get($task_id, $get_subtasks);
    endif;
    
    // Send response
    api__response(200, $results);

    break;

  case "PATCH":

    // Include module functions
    require_once("update.php");

    $data = api__request_data();
    $task_id  = null;

    if(isset($data['task_id'])):
      $task_id = $data['task_id'];
      unset($data['task_id']);
    endif;

    if (empty($task_id)) :
      debug__log("Unable to update task due to missing task id");
      api__response(400, "Missing task id");
    elseif (empty($data)) :
      debug__log("Unable to update task due to missing fields");
      api__response(400, "Missing task fields to update");
    endif;

    tasks__update($task_id, $data);
    
    api__response(200, "Task updated");

    break;

  case "PUT":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not supported");
    break;
    
  case "DELETE":

    require_once("delete.php");
    extract(api__request_data());

    if(empty($task_id)) :
      debug__log("Unable to remove task due to missing task id");
      api__response(400, "Missing task id");
    endif;

    tasks__delete($task_id);
    api__response(200, "Task deleted");

  break;

endswitch;