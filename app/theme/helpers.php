<?php

  /* -------------------------------
   ------------------------------- */

  /**
   * If user is not signed in, redirect to login page
   * 
   * @return nothing
   * 
   */ 

  function login_required($returnState = false) {
    $loggedIn = is_logged_in();
    if (!$loggedIn && !$returnState) {
      header('Location: /login', true, 302);
      die();
    }
    return $loggedIn;
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Check if the password is strong
   * 
   * @return boolean
   * 
   */ 

  function password_is_strong($password) {
    
    $uppercase      = preg_match('@[A-Z]@', $password);
    $lowercase      = preg_match('@[a-z]@', $password);
    $number         = preg_match('@[0-9]@', $password);
    $special_chars  = preg_match('@[^\w]@', $password);

    return ($uppercase && $lowercase && $number && $special_chars && strlen($password) >= 8);

  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Check if two passwords match
   * 
   * @return boolean
   * 
   */ 

  function passwords_match($pwd1, $pwd2) {
    
    // Check if passwords was provided
    if(!isset($pwd1) || !isset($pwd2)) return false;

    // Check if the passwords match
    if($pwd1 !== $pwd2) return false;

    return true;

  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Validate one or two passwords
   * 
   * @return array
   * 
   */ 

  function password_validation($pwd1, $pwd2 = null) {
    
    $message = "";

    if(!isset($pwd1)) 
      return ["error" => true, "message" => "Lösenord saknas"];

    // If a second password was provided,
    // check if the two passwords match
    if($pwd2 != null):
      if(!passwords_match($pwd1, $pwd2))
        return ["error" => true, "message" => "Lösenorden stämmer inte överrens."];
    endif;

    // Validate password
    if(!password_is_strong($pwd1)) :
      $message = "Lösenordet måste vara minst 8 tecken långt, innehålla minst en siffra, en stor och liten bokstav samt ett specialtecken.";
      return ["error" => true, "message" => $message];
    endif;
    
    return ["error" => false];

  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Process account activation
   * 
   * @return array
   * 
   */ 

  function process_account_activation($post_data){

    extract($post_data);

    // Check if passwords pass validation
    $pwd_check = password_validation($password, $password_again);

    if($pwd_check["error"]) 
      return $pwd_check;

    // Activate user  
    $user_obj = ui__api_post("/activate-account", ['password' => urlencode($password), 'token' => $token], null, null);

    if(empty($user_obj)) 
      return ["error" => true, "message" => "Aktiveringen misslyckades"];
    
    // Redirect to dashboard on sucessfull activation
    set_session_user_data($user_obj[0]);
    header("Location: /dashboard");

  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Process password reset request
   * 
   * @return array
   * 
   */ 

  function process_password_reset($post_data){

    extract($post_data);
    
    // If a token is provided, go ahead and reset the password
    if(!empty($token)):
      return reset_password($post_data);
    endif;

    // Get a new token for the user
    $results = ui__api_get("/reset-password", ['email' => $email], APP_USER, APP_PASS);
    
    if(!isset($results['token'])):
      return ["error" => true, "message" => "Vi kunde inte hitta användaren 🤔"];
    endif;

    // Send reset link to the user
    return send_password_reset_link(['token' => $results['token'], 'email' => $email]);

  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Send a account activation link to user
   * 
   * @return array
   * 
   */ 

  function send_account_activation_link($data){
    
    $data["url"] = BASE_URL."/activate?token=".$data["token"];
    $data["contact_person"] = SYSTEM_ADMIN_EMAIL;
    
    ob_start();
    ui__view_fragment("email".DS."welcome-to-ombord.php", $data);
    $body = ob_get_clean();

    $to       = $data["email"];
    $subject  = "Välkommen till Ombord";
    $headers  =  "";

    $mail_res = mail($to, $subject, $body, $headers);

    if(!$mail_res):
      return ["error" => true, "message" => "Det gick inte att skicka en aktiveringslänk."];
    endif;
    
    return ["error" => false];

  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Send a password reset link to user
   * 
   * @return array
   * 
   */ 

  function send_password_reset_link($data){
    
    $data["url"] = BASE_URL."/reset?token=".$data['token'];
    
    ob_start();
    ui__view_fragment("email".DS."reset-password.php", $data);
    $body = ob_get_clean();

    $to       = $data["email"];
    $subject  = "Lösenordsåterställning på Ombord";
    $headers  =  "";
    $mail_res = mail($to, $subject, $body, $headers);

    if(!$mail_res)
      return ["error" => true, "message" => "Det gick inte att skicka en återställningslänk."];
    
    return ["error" => false];

  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Reset password
   * 
   * @return array
   * 
   */ 

  function reset_password($data) {

    if(empty($data)) 
      return ["error" => true, "message" => "Ingen data"];
        
    extract($data);
    
    // Check if passwords pass validation
    $pwd_check = password_validation($password, $password_again);

    // Return error if any
    if($pwd_check["error"]) return $pwd_check;
    
    // Checks are OK. Change password.
    $args = ['password' => urlencode($password)];
    if(isset($token)):
      $args['token'] = $token;
      $pwd_changed = ui__api_post("/reset-password", $args, APP_USER, APP_PASS);
    elseif(isset($user_id)):
      $args['user_id'] = $user_id;
      $pwd_changed = ui__api_post("/reset-password", $args, null, null);
    endif;
    
    $message = "";
    
    // Check if password was changed or not
    if(!$pwd_changed) $message = "Lösenordsändringen misslyckades.";

    return ["error" => !empty($message), "message" => $message];

  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Check if user is signed in by looking fo a user session
   * 
   * @return bool
   * 
   */ 

  function is_logged_in() {
    return isset($_SESSION['user']);
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Check if user is signed in by looking fo a user session
   * 
   * @return bool
   * 
   */ 

  function is_admin() {
    if(!isset($_SESSION['user']['is_admin'])) return 0;
    return $_SESSION['user']['is_admin'];
  }


  function set_session_user_data($user_obj){
    
    // Set variables to session
    $_SESSION["user"]["id"] = $user_obj['id'];
    $_SESSION["user"]["api_user"] = $user_obj['api_user'];
    $_SESSION["user"]["api_secret"] = $user_obj['api_secret'];
    
    // Get user data
    $user_obj = ui__get_user($user_obj['id']);

    $_SESSION["user"]["name"] = $user_obj['firstname'];
    $_SESSION["user"]["email"] = $user_obj['email'];
    $_SESSION["user"]["img"] = $user_obj['img'];
    $_SESSION["user"]["is_admin"] = $user_obj['is_admin'];
  }

  /* -------------------------------
   ------------------------------- */

  /**
   * Get user id from session
   * 
   * @return string
   * 
   */ 

  function get_user_id(){
    return (isset($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : null;
  }



  /* -------------------------------
   ------------------------------- */

  /**
   * Get user api id from session
   * 
   * @return string
   * 
   */ 

  function get_api_user(){
    return (isset($_SESSION['user']['api_user'])) ? $_SESSION['user']['api_user'] : null;
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Get user secret from session
   * 
   * @return string
   * 
   */ 

  function get_api_secret(){
    return (isset($_SESSION['user']['api_secret'])) ? $_SESSION['user']['api_secret'] : null;
  }



 /* -------------------------------
   ------------------------------- */

  /**
   * Get project id from url
   * 
   * @return string
   * 
   */ 

  function get_project_id(){
    preg_match('/projects\/([0-9]*)/', $_SERVER["REQUEST_URI"], $matches);
    if(!isset($matches[1])) return null;
    return $matches[1];
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Get list id from url
   * 
   * @return string
   * 
   */ 

  function get_list_id(){
    preg_match('/lists\/([0-9]*)/', $_SERVER["REQUEST_URI"], $matches);
    if(!isset($matches[1])) return null;
    return $matches[1];
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Get task id from url
   * 
   * @return string
   * 
   */ 

  function get_task_id(){
    preg_match('/tasks\/([0-9]*)/', $_SERVER["REQUEST_URI"], $matches);
    if(!isset($matches[1])) return null;
    return $matches[1];
  }


 /* -------------------------------
   ------------------------------- */

  /**
   * Get team member id from url
   * 
   * @return string
   * 
   */ 

  function get_team_member_id(){
    preg_match('/team\/([0-9]*)/', $_SERVER["REQUEST_URI"], $matches);
    if(!isset($matches[1])) return null;
    return $matches[1];
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Get a project url
   * 
   * @return string
   * 
   */ 

  function ui__get_project_url($project_id){
    return "/projects/".$project_id;
  }

  /* -------------------------------
   ------------------------------- */

  /**
   * Get a list url
   * 
   * @return string
   * 
   */ 

  function ui__get_list_url($list_id){
    $url = "";
    if(!empty(get_project_id())){
      $url .="/projects/".get_project_id();
    }
    $url .="/lists/".$list_id;

    return $url;
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Get task url
   * 
   * @return string
   * 
   */ 

  function ui__get_task_url($task_id){
    $url = "";
    if(!empty(get_project_id())){
      $url .="/projects/".get_project_id();
    }

    if(!empty(get_list_id())){
      $url .="/lists/".get_list_id();
    }

    $url .="/tasks/".$task_id;

    return $url;
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Get a list with sorted tasks from database
   * 
   * @param list_id (string)
   * 
   * @param sort_id (string/array)
   * 
   * @return array
   * 
   */ 

  // function get_sorted_list_tasks($list_id, $sort_order, $user_id = "") {
  //   debug__log("UI: get_sorted_list_tasks() ");
  //   $tasks = get_list_tasks($list_id, $user_id);
  //   return ui__sort_tasks($tasks, $sort_order);
  // }


/* -------------------------------
   ------------------------------- */

  /**
   * Get users
   * 
   * @param $user_id (int) - optional
   * 
   * @return array
   * 
   */

  function ui__get_users($user_id = null) {
    $data = ui__api_get("/users", ["user_id" => $user_id]);
    if(empty($data)) return [];
    return $data;
  }

  // Same as above but returns only one result
  function ui__get_user($user_id) {
    $data = ui__get_users($user_id);
    if(count($data) > 1) return $data;
    return $data[0];
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Get projects
   * 
   * @param $project_id (int)
   * @param $user_id (int)
   * 
   * @return array
   * 
   */

  function ui__get_projects($project_id = null, $user_id = null) {
    $data = ui__api_get("/projects", ["project_id" => $project_id, 'user_id'=>$user_id]);
    if(empty($data)) return [];
    return $data;
  }

  // Same as above but returns only one result
  function ui__get_project($project_id = null, $user_id = null) {
    $data = ui__get_projects($project_id, $user_id);
    if(count($data) < 1) return $data;
    return $data[0];
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Get all users that are assigned a specific project
   * 
   * @param $project_id (int)
   * 
   * @return array
   * 
   */

  function ui__get_project_users($project_id) {
    $data = ui__api_get("/projects/users", ["project_id" => $project_id]);
    return $data;
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Get lists
   * 
   * @param $list_id (int)
   * @param $args (array)
   * 
   * @return array
   * 
   */

  function ui__get_lists($list_id = null, $args = []) {

    $params = $args;
    
    $params['list_id'] = $list_id;
    $lists = ui__api_get("/lists", $params);

    // Get all lists that belongs to a specific task
    $task_lists = [];
    if(isset($args['task_id'])):

      $task_lists = ui__api_get("/tasks/lists", ["id" => $args['task_id']]);
      if(!empty($task_lists)):
        $task_lists_tmp = [];
        foreach ($task_lists as $key => $list) :
          array_push($task_lists_tmp, $list['id']);
        endforeach;
        $task_lists = $task_lists_tmp;
      endif;

    endif;

    if(!empty($task_lists) && !empty($lists)):

      $lists_tmp = $lists;
      foreach ($lists as $key => $list) :
        if(in_array($list['id'], $task_lists)):
          $lists_tmp[$key]['is_chosen'] = 1;
        else:
          $lists_tmp[$key]['is_chosen'] = 0;
        endif;
      endforeach;
      $lists = $lists_tmp;
    endif;

    if(empty($lists)) return [];
    return $lists;
  }

  // Same as above but returns only one result
  function ui__get_list($list_id = null) {
    $data = ui__get_lists($list_id);
    if(count($data) < 1) return $data;
    return $data[0];
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Get tasks from API
   * 
   * @param $task_id (int)
   * @param $list_id (int)
   * 
   * @return array
   * 
   */

  function ui__get_tasks($task_id = null, $list_id = null) {
    $data = ui__api_get("/tasks", ["task_id" => $task_id, 'list_id' => $list_id]);
    if(empty($data)) return [];
    return $data;
  }

  function ui__get_task($task_id = null, $list_id = null) {
    $data = ui__get_tasks($task_id, $list_id, $args = []);
    if(empty($data)) return [];
    if(count($data) > 1) return $data;
    return $data[0];
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Sort items
   * 
   * @param $items (array)
   * @param $order (string or array)
   * 
   * @return array
   * 
   */

  // Sort items based on a provided order
  function ui__sort_items($items, $order) {

    if(empty($items) || empty($order)) return $items;

    // If $order is a comma separated string
    // convert it into an array
    if(!is_array($order)) :
      $order = str_replace(' ', '', $order);
      $order  = explode(",", $order);
    endif;

    $keys = array_flip($order);

    usort($items, function ($a, $b) use ($keys) {
      if(!isset($keys[$a['id']]) || !isset($keys[$b['id']]))
        return 1;

      return $keys[$a['id']] > $keys[$b['id']] ? 1 : -1;
    });

    return $items;

  }

  function ui__sort_tasks($tasks, $order) {
    return ui__sort_items($tasks, $order);
  }

  /* -------------------------------
   ------------------------------- */

  /**
   * Get tasks from API and sort them
   * Combinates ui__get_tasks() and ui__sort_tasks()
   * 
   * @param $list_id (int)
   * @param $task_order (string)
   * 
   * @return array
   * 
   */

  function ui__get_sorted_tasks($list_id, $task_order) {
    $tasks = ui__get_tasks(null,$list_id);
    return ui__sort_tasks($tasks,$task_order);
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Load view
   * 
   * @param $type (string)
   * 
   * @return array
   * 
   */

  function ui__get_breadcrumbs($type) {
    if(empty($type) || empty($type)) return [];
    include(THEME.DS."modules".DS."breadcrumbs".DS.$type.".php");
    return $breadcrumbs;
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Load view
   * 
   * @param $type (string)
   * - name of the subfoder within theme/<theme_name>/
   * @param $view (string)
   * - name if the view file
   * 
   * @return nothing
   * 
   */

  function ui__view($type, $view, $data = []) {
    $filename = THEME.DS.strtolower($type).DS.strtolower($view);
    if(!file_exists($filename)):
      debug__log("view not found: ". $filename);
    else:
      include($filename);
    endif;
    unset($data);
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Load fragment
   * 
   * @param $view (string)
   * 
   * @return nothing
   * 
   */

  function ui__view_fragment($view, $data = []) {
    ui__view("fragments", $view, $data);
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Load page view
   * 
   * @param $view (string)
   * 
   * @return nothing
   * 
   */

  function ui__view_page($view, $data = []) {
    ui__view("pages", $view, $data);
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Load module template
   * 
   * @param $module_name (string)
   * 
   * @param $module_view (string)
   * 
   * @param $module (array)
   * - Data to be used within the module
   * 
   * @return nothing
   * 
   */

  function ui__view_module($module_name, $module_view, $module) {
    if(empty($module_name) || empty($module_view)) return "";
    include(THEME.DS."modules".DS.$module_name.DS.$module_view);
    unset($module);
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Load 404 view for projects
   * 
   * @return nothing
   * 
   */

  // function ui__view_project_404(){
  //   include_once(THEME.DS."pages".DS."error-404-project.php"); 
  //   exit();
  // }



  /* -------------------------------
   ------------------------------- */

  /**
   * Escape bad characters in HTML and convert line breaks to <br>
   * 
   * @return nothing
   * 
   */ 

  function escape_html($string) {
    return nl2br(htmlentities($string));
  }

  /* -------------------------------
   ------------------------------- */

  /**
   * Shortcut for making GET requests
   * 
   * @return array
   * 
   */ 

  function ui__api_get($endpoint, $data=False, $username=False, $password=False, $result_headers=False) {
    $url = BASE_URL_API.$endpoint;
    $response = ui__send_authorized_request( $url, 'GET', $username, $password, $data, $result_headers);
    return $response;
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Shortcut for making POST requests
   * 
   * @return array
   * 
   */ 

  function ui__api_post($endpoint, $data, $username=False, $password=False, $result_headers=False) {
    $url = BASE_URL_API.$endpoint;
    $response = ui__send_authorized_request( $url, 'POST', $username, $password, $data, $result_headers);
    return $response;
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Shortcut for making PUT requests
   * 
   * @return array
   * 
   */ 

  function ui__api_patch($endpoint, $data, $username=False, $password=False, $result_headers=False) {
    $url = BASE_URL_API.$endpoint;
    $response = ui__send_authorized_request( $url, 'PATCH', $username, $password, $data, $result_headers);
    return $response;
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Shortcut for making DELETE requests
   * 
   * @return array
   * 
   */ 

  function ui__api_delete($endpoint, $data, $username=False, $password=False, $result_headers=False) {
    $url = BASE_URL_API.$endpoint;
    $response = ui__send_authorized_request( $url, 'DELETE', $username, $password, $data, $result_headers);
    return $response;
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Helper for making requests
   * 
   * @return array
   * 
   */

  function ui__send_authorized_request( $url, $method, $username, $password, $data=NULL, $result_headers=True) {
    
    $username=$username?$username:get_api_user();
    $password=$password?$password:get_api_secret();

    if (isset($data)) :
      $context = stream_context_create(array(
        'http' => array(
          'method' => $method,
          'content' => http_build_query($data),
          'header'  => 
            "Authorization: Basic ". base64_encode($username.':'.$password). "\r\n".
            "Content-type: application/x-www-form-urlencoded\r\n",
          'ignore_errors' => $result_headers
        )
      ));
    else:
      $context = stream_context_create(array(
        'http' => array(
          'method' => $method,
          'header'  => 
          "Authorization: Basic ". base64_encode($username.':'.$password). "\r\n".
            "Content-type: application/x-www-form-urlencoded\r\n",
          'ignore_errors' => $result_headers
        )
      ));
    endif;

    $result = file_get_contents($url, false, $context);

    if($result_headers) return array(json_decode($result, true), $http_response_header);

    return json_decode($result, true);

  }