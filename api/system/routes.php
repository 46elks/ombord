<?php 

$request = $_SERVER["REQUEST_URI"];

// Route pages to its corresponding view
switch ($request) {

  case '/api/v1/tasks':
  case '/v1/tasks':
    load_model("tasks", "index");
    break;
  
  case '/api/v1/tasks/lists':
  case '/v1/tasks/lists':
    load_model("tasks/lists", "index");
    break;

  case '/api/v1/projects':
  case '/v1/projects':
    load_model("projects", "index");
    break;
  case '/api/v1/projects/users':
  case '/v1/projects/users':
    load_model("projects/users", "index");
    break;

    case (bool)preg_match('/^(.*?)\/projects\/([0-9]+?)\/lists\/([0-9]*?)$/', $request):
    load_model("projects/lists", "index");
    break;

  case '/api/v1/lists':
  case '/v1/lists':
    load_model("lists", "index");
    break;

  case '/api/v1/lists/tasks':
  case '/v1/lists/tasks':
    load_model("lists/tasks", "index");
    break;

  case '/api/v1/users':
  case '/v1/users':
    load_model("users", "index");
    break;
  case '/api/v1/users/lists':
  case '/v1/users/lists':
    load_model("users/lists", "index");
    break;
  case '/api/v1/users/tasks':
  case '/v1/users/tasks':
    load_model("users/tasks", "index");
    break;
case '/api/v1/users/projects':
  case '/v1/users/projects':
    load_model("users/projects", "index");
    break;
  
  case '/api/v1/app/login':
  case '/v1/app/login':
    load_model("app", "login");
    break;
  
  case (bool)preg_match('/^\/api\/v1\/activate-account\/?(.*?)$/', $request):
  case (bool)preg_match('/^\/v1\/activate-account\/?(.*?)$/', $_SERVER["REQUEST_URI"]):
    load_model("app", "activate-account");
    break;

  case (bool)preg_match('/^\/api\/v1\/reset-password\/?(.*?)$/', $_SERVER["REQUEST_URI"]):
  case (bool)preg_match('/^\/v1\/reset-password?(.*?)$/', $_SERVER["REQUEST_URI"]):
    load_model("app", "reset-password");
    break;
    
  default:
    api__response(404, "Endpoint not found");

}