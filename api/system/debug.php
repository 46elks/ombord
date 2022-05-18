<?php 


/* -------------------------------
 ------------------------------- */

/**
 * Debug
 * 
 * @param data (array/string)
 * 
 * @return nothing
 * 
 */

  function debug($data) {
    if (is_array($data)) :
      echo "<pre>";
      print_r($data);
      echo "</pre>";
    else:
      echo $data."<br>";
    endif;
  }


/* -------------------------------
 ------------------------------- */

/**
 * Debug function which intend to make your life easier 
 * when things doesn't work as expected.
 * 
 * @param data (array/string)
 * 
 * @return nothing
 * 
 */

  function debug__log($data){
    global $debug_log;
    
    if(!is_array($debug_log)) $debug_log = [];
    array_push($debug_log, $data);

    // Save data to logfile
    $logfile = LOGS.DS.date("Y-m-d").".log";
    if(is_array($data)):
      foreach ($data as $value) {
        file_put_contents($logfile, date("y-m-d H:i:s - ").$value.PHP_EOL, FILE_APPEND);
      }
    else:
      file_put_contents($logfile, date("y-m-d H:i:s - ").$data.PHP_EOL, FILE_APPEND);
    endif;
  }


  function debug__show(){
    
    if(!DEBUG) return false;

    global $debug_log;
    echo "<hr>";
    echo "<h2>Debug log</h2>";
    print_r($_GET);
    echo "<br>";
    foreach ($debug_log as $key => $value) {
      
      if(is_array($value)):
        echo "<pre>";
        print_r($value);
        echo "</pre>";
      else:
        echo $value."<br>";
      endif;
    }
  }
