<?php 

/**
 * Responder for XMLHttpRequest
 * 
 */
header("Content-type:application/json");
// login_required();

$data = (array)json_decode(file_get_contents("php://input"), true);

extract($data); 
$action = $data['_action'];
unset($data["_action"]);

switch (strtoupper($action)) {
  
  // TASKS
  case 'GET_TASK':
    if(!isset($get_subtasks)) $get_subtasks = false;
    $data = ["task_id" => $task_id, "get_subtasks" => $get_subtasks];
    $result = ui__api_get("/tasks", $data, false, false, true);
    if(count($result[0]) > 0) $result[0] = $result[0][0];
    parse_request($result[0], $result[1]);
    break;

  case 'GET_TASKS':
    if(!isset($get_subtasks)) $get_subtasks = false;
    $data = ["list_id" => $list_id, "get_subtasks" => $get_subtasks];
    $result = ui__api_get("/lists/tasks", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;

  case 'ADD_TASK':
    $data = ["title" => $title, "list_id" => $list_id];
    $result = ui__api_post("/tasks", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;

  case 'COMPLETE_TASK':
    $data = ["task_id" => $task_id, "is_completed" => $is_completed];
    $result = ui__api_patch("/tasks", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;

  case 'UPDATE_TASK':
    $new_data = [];
    foreach ($data as $key => $value) {
      $new_data[$key] = $value;
    }

    // echo json_encode(/$new_data);
    $result = ui__api_patch("/tasks", $new_data, false, false, true);
    parse_request($result[0], $result[1]);
    break;

  case 'DELETE_TASK':
    $data = ["task_id" => $task_id];
    $result = ui__api_delete("/tasks", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;

  // LISTS
  case 'GET_LIST':
    $data = ["list_id" => $list_id];
    $result = ui__api_get("/lists", $data, false, false, true);
    if(count($result[0]) > 0) $result[0] = $result[0][0];
    parse_request($result[0], $result[1]);
    break;

  case 'ADD_LIST':
    $data = ["title" => $title, "project_id" => $project_id];
    $result = ui__api_post("/lists", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;

  case 'UPDATE_TASKS_ORDER':
    $data = ["list_id" => $list_id, "tasks_order" => trim($tasks_order)];
    $result = ui__api_patch("/lists", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;

  case 'UPDATE_LIST':
    $data = ["list_id" => $list_id, "description" => $description, "title"=>$title];
    $result = ui__api_patch("/lists", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;

  case 'DELETE_LIST':
    $data = ["list_id" => $list_id];
    $result = ui__api_delete("/lists", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;

  case 'ADD_LIST_TASK':
    $data = ["task_id" => $task_id, "list_id" => $list_id];
    $result = ui__api_post("/lists/tasks", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;

  case 'DELETE_LIST_TASK':
    $data = ["task_id" => $task_id, "list_id" => $list_id];
    $result = ui__api_delete("/lists/tasks", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;

  // PROJECTS
  case 'ADD_PROJECT':
    if(isset($template_project) && $template_project != "0") $data['project_id'] = $template_project;
    // $data = ["title" => $title, "project_id" => $template_id];
    $result = ui__api_post("/projects", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;

  case 'UPDATE_PROJECT':
    $result = ui__api_patch("/projects", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;

  case 'DELETE_PROJECT':
    $result = ui__api_delete("/projects", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;


  // USERS
  case 'ADD_USER':

    if (isset($data['name'])) :
      $name = explode(' ', $data['name'], 2);
      if(count($name) > 1):
        $data['firstname'] = $name[0];
        $data['lastname'] = $name[1];
      else:
        $data['firstname'] = $name[0];
      endif;
      unset($data['name']);
    endif;

    $result = ui__api_post("/users", $data, false, false, true);
    $user_id = (isset($result[0]['id'])) ? $result[0]['id'] : null;

    // Create project for user
    if(isset($template_project) && !empty($user_id)):

      if(!isset($description)) $description = null;
      $project_data = [
        'name' => "Onboarding ".$data['firstname'],
        'title' => "Välkommen ".$data['firstname'],
        'description' => $description,
        'user_id' => $user_id, 
        'project_id' => $template_project,
      ];
      $new_project = ui__api_post("/projects", $project_data, false, false, true);
      if (respons_is_200($new_project[1])) :
        $result[0]['project_id'] = $new_project[0]['id'];
      else:
        $result[0]['project_id'] = null;
      endif;
      
    endif;

    // Send account activation link via email
    if(isset($result[0]['token']) && isset($data['email']) && respons_is_200($result[1])):
      send_account_activation_link(["name" => $data['firstname'], "email" => $data['email'],"token" => $result[0]['token']]);
    endif;
      
    // Return results
    parse_request($result[0], $result[1]);

    break;


  case 'ADD_USER_ADMIN':
    if(empty($data['password'])) $data['password'] = "admin";

    if (isset($data['name'])) :
      $name = explode(' ', $data['name'], 2);
      if(count($name) > 1):
        $data['firstname'] = $name[0];
        $data['lastname'] = $name[1];
      else:
        $data['firstname'] = $name[0];
      endif;
      unset($data['name']);
    endif;

    $result = ui__api_post("/users", $data, false, false, true);
    
    $user_id = (isset($result[0]['id'])) ? $result[0]['id'] : null;
          
    // if(respons_is_200($result[1])):
    //   $user_obj = ui__api_post("/app/login", [], $data['email'], $data['password']);
    //   set_session_user_data($user_obj);
    //   // header("Location: /dashboard");
    // endif;

    // Return results
    parse_request($result[0], $result[1]);

    break;
  
  case 'UPDATE_USER':
    $result = ui__api_patch("/users", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;

  case 'ADD_USER_PROJECT':
    $result = ui__api_post("/users/projects", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;
  
  case 'DELETE_USER_PROJECT':
    $result = ui__api_delete("/users/projects", $data, false, false, true);
    parse_request($result[0], $result[1]);
    break;

  default:
    http_response_code(404);
    echo json_encode("No action found");
    break;
}


function respons_is_200($headers){
  return (bool)strstr($headers[0],"200 OK");
}

function parse_request($result, $headers){
  if (!strstr($headers[0],"200 OK")): 
    preg_match("/[0-9][0-9][0-9]/", $headers[0], $matches);
    http_response_code($matches[0]);
  endif;
  echo json_encode($result);
}