<?php 

$request = $_SERVER["REQUEST_URI"];

// Route pages to its corresponding view
switch ($_SERVER["REQUEST_URI"]) {


  // =====================================
  // Website routes
  // =====================================
  case '/':
    ui__view_page("startpage.php");
    break;

  case '/dashboard':
  case '/dashboard/':
    ui__view_page("dashboard.php");
    break;

  case '/form-submit':
  case '/form-submit/':
    ui__view_page("form-submit.php");
    break;

  case '/uploader':
  case '/uploader/':
    ui__view_page("uploader.php");
    break;

  case (bool)preg_match('/^(.*?)\/uploads\/(.*?)$/', $request):
    ui__view_page("uploads.php");
    break;
  
  // Single list
  case (bool)preg_match('/^(.*?)\/lists\/([0-9]*)$/', $request):
    ui__view_page("list.php");
    break;

  // Single task
  case (bool)preg_match('/^(.*?)\/tasks\/([0-9]*)$/', $request):
    ui__view_page("task.php");
    break;

  case "/new-project":
    ui__view_page("new-project.php");
    break;
  
  case '/login':
  case (bool)preg_match('/^(.*?)\/login(.*?)$/', $request):
    ui__view_page("login.php");
    break;

  case '/team':
  case (bool)preg_match('/^(.*?)\/team(.*?)$/', $request):
    ui__view_page("team.php");
    break;

  case '/new-user':
    ui__view_page("add-new-user.php");
    break;

  case '/projects':
  case (bool)preg_match('/^(.*?)\/projects\/?(.*?)$/', $request):
    ui__view_page("projects.php");
    break;

  case (bool)preg_match('/^\/activate\/?(.*?)$/', $request):
  case '/activate':
    ui__view_page("activate.php");
    break;

  case '/logout':
    ui__view_page("logout.php");
    break;
  
  default:
    ui__view_page("error-404.php");
    break;
  
}