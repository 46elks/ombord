<?php 

header("Access-Control-Allow-Methods: PATCH");

// Ensure request is authenticated
api__is_authenticated();

switch(strtoupper($_SERVER['REQUEST_METHOD'])):
  
  case "POST":
    
    $data = api__request_data();
    extract(get_project_list_id());

    // Add a list to the project
    if(!empty($old_project_id) && empty($old_list_id)):
      if(empty($data['list_id'])) :
        debug__log("Unable to add list to a new project due to missing list id");
        api__response(400, "Missing list id");
      endif;

      load_model("projects".DS."lists","add");
      projects_lists__add($old_project_id, $data['list_id']);
      api__response(200, "List added to the project");
    

    // Copy the list
    elseif(!empty($old_project_id) && !empty($old_list_id)):

      $new_project_id = (isset($data['project_id']) && !empty($data['project_id'])) ? $data['project_id'] : null;
      load_model("projects".DS."lists","copy");
      $new_list_id = projects_lists__copy($old_project_id, $old_list_id, $new_project_id);
      // api__response(200, "List copied to the project");
      api__response(200, ['project_id' => $new_project_id, 'list_id' => $new_list_id]);
      
    else:
      api__response(400, "Your request did not match any valid actions");
    endif;

    break;
    
  case "GET":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not yet supported");
    break;

  case "PUT":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not yet supported");
    break;

  case "PATCH":
     
    $data = api__request_data();
    extract(get_project_list_id());

    if(empty($old_project_id)) :
      debug__log("Unable to move list to a new project due to missing old_project id");
      api__response(400, "Missing old project id");
    elseif(empty($data['project_id'])) :
      debug__log("Unable to move list to a new project due to missing new_project id");
      api__response(400, "Missing new project id");
    elseif(empty($old_list_id)) :
      debug__log("Unable to move list to project due to missing list id");
      api__response(400, "Missing list id");
    endif;

    // Include module functions
    load_model("projects".DS."lists","move");

    projects_lists__move($old_project_id, $data['project_id'], $old_list_id);

    // api__response(200, "List moved to new project");
    api__response(200, ['project_id' => $data['project_id'], 'list_id' => $old_list_id]);

    break;
  case "DELETE":
    api__response(400, $_SERVER['REQUEST_METHOD']." is not yet supported");
    break;
    
endswitch;


function get_project_list_id(){
  preg_match('/^.*?\/projects\/([0-9]*?)\/lists\/([0-9]*?)$/', $_SERVER["REQUEST_URI"], $matches);

  $old_project_id = (isset($matches[1])) ? $matches[1] : "";
  $old_list_id = (isset($matches[2])) ? $matches[2] : "";

  return ["old_project_id" => $old_project_id, 'old_list_id' => $old_list_id];
}