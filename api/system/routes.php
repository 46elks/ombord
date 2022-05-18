<?php 

$request = $_SERVER["REQUEST_URI"];

// Route pages to its corresponding view
switch ($_SERVER["REQUEST_URI"]) {

  case '/v1/tasks':
    load_model("tasks", "index");
    break;

  case '/v1/projects':
    load_model("projects", "index");
    break;

  case '/v1/lists':
    load_model("lists", "index");
    break;

  case '/v1/lists/tasks':
    load_model("lists/tasks", "index");
    break;

  case '/v1/users':
    load_model("users", "index");
    break;
  case '/v1/users/lists':
    load_model("users/lists", "index");
    break;
  case '/v1/users/tasks':
    load_model("users/tasks", "index");
    break;
  
  case '/v1/app/login':
    load_model("app", "login");
    break;
    
  default:
    api__response(404, "Endpoint not found");

}