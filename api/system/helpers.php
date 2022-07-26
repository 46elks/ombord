<?php 


  function get_auth_user(){
    return $_SERVER['PHP_AUTH_USER'];
  }
  
  // Get the authenticated user id
  function get_user_id() {
    return get_mysql_id();
  }

  function get_mysql_id(){

    global $mysql_id;

    if(isset($mysql_id) && !empty($mysql_id)) return $mysql_id;

    $params = ['api_user' => $_SERVER['PHP_AUTH_USER'], 'api_secret' => $_SERVER['PHP_AUTH_PW']];
    $sql =<<< SQL
      SELECT id 
      FROM users 
      WHERE api_user = :api_user 
        AND api_secret = :api_secret
        AND is_deleted = 0 
      LIMIT 1;
SQL;

    $result = db__select($sql, $params);

    if(isset($result[0]['id']) && !empty($result[0]['id'])) $mysql_id = $result[0]['id'];
    
    return $mysql_id;

  }

  // Send response
  function api__response($status_code, $message) {
    http_response_code($status_code);
    exit(json_encode($message));
  }

  // Get the data within the received request
  function api__request_data() {
    parse_str(urldecode(file_get_contents("php://input")), $data);

    // Decode any URL encoded values
    $decoded_data = [];
    foreach ($data as $key => $value) {
      $decoded_data[$key] = urldecode($value);
    }

    return $decoded_data;
  }

  // Check if user is correctly authenticathed
  function api__is_authenticated(){

    if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) :
      header('WWW-Authenticate: Basic realm="My Realm"');
      http_response_code(401);
      exit(json_encode("Invalid username and password"));
    else:
      if (empty(get_mysql_id())) :
        header('WWW-Authenticate: Basic realm="My Realm"');
        http_response_code(401);
        exit(json_encode("Invalid username and password"));
      endif;

      return true;

    endif;
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Load module model
   * 
   * @param $module (string)
   * - name of the module
   * 
   * @param $model (string)
   * - name of the model
   * 
   * @return bool
   * 
   */

  function load_model($module, $model){
    if(empty($model)) $model = "_inc.php";
    $file_path = ROOT.DS."modules".DS.$module.DS.$model.".php";
    if (!file_exists($file_path)):
      debug__log("No model not fount at ". $file_path);
      return false;
    endif;
    include_once($file_path);
    return true;
  }


  /* -------------------------------
   ------------------------------- */

  /**
   * Generate a password hash
   * 
   * @param $password (string)
   * 
   * @return string
   * 
   */

  function get_hashed_password($password){
    return password_hash($password, PASSWORD_BCRYPT);
  }