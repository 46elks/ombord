<?php 

header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");

// Ensure request is authenticated
api__is_authenticated();

switch(strtoupper($_SERVER['REQUEST_METHOD'])):
  
  case "POST":

    // Get data from request
    extract(api__request_data());

    // Include module functions
    load_model("lists","add");
    
    if (!isset($title)) $title = null;
    if (!isset($description)) $description = null;

    // Create new list
    $list_id = lists__add($title, $description);

    // Add list to project
    if (isset($project_id) && !empty($list_id)):
      load_model("projects".DS."lists", "add");
      projects_lists__add($project_id,$list_id);
    endif;

    // Send response
    api__response(200, ['id' => $list_id]);
    
    break;
    
  case "GET":

    // Get data from request
    extract(api__request_data());

    if(isset($project_id)):
      // Include module functions
      load_model("projects".DS."lists", "get");
      $results = projects_lists__get($project_id);
    else:
      // Include module functions
      load_model("lists", "get");
      if(!isset($list_id)) $list_id = null;
      $results = lists__get($list_id);
    endif;

    api__response(200, $results);

    break;

  case "PUT":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not yet supported");
    break;
  case "PATCH":
     
    // Include module functions
    load_model("lists","update");

    $data = api__request_data();

    if(empty($data['list_id'])) :
      debug__log("Unable to update list due to missing list id");
      api__response(400, "Missing list id");
    endif;

    $list_id = $data['list_id'];
    unset($data['list_id']);

    if (empty($data)) :
      debug__log("Unable to update task due to missing fields");
      api__response(400, "Missing task fields to update");
    endif;

    lists__update($list_id, $data);
    api__response(200, "List updated");

    break;
  case "DELETE":
    extract(api__request_data());

    if(empty($list_id)) :
      debug__log("Unable to remove list due to missing list id");
      api__response(400, "Missing list id");
    endif;

    load_model("lists","delete");
    lists__delete($list_id);
    api__response(200, "List deleted");
    break;
    
endswitch;