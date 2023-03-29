<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Copy tasks
   *
   * @param $old_list (int) - required
   * @param $new_list (int) - required
   *
   * @return int (id of row) or false
   *
   */

  function lists_tasks__copy($old_list, $new_list, $copied_tasks = array()){
    
    // 1. Get tasks from old list
    load_model("lists".DS."tasks","get");
    $tasks = list_tasks__get($old_list);

    // 2. Copy each task
    foreach ($tasks as $key => $old_task) :
      
      // If the current task is a linked tasks it should
      // not be copied again, but referenced in the new list
      if (array_key_exists($old_task['id'], $copied_tasks)):
        list_tasks__add($new_list, $copied_tasks[$old_task['id']]);
        continue;
      endif;

      $title = (isset($old_task['title'])) ? $old_task['title'] : "";
      $description = (isset($old_task['description'])) ? $old_task['description'] : "";
      
      load_model("tasks","add");
      $new_task = tasks__add($title, $description);
      $copied_tasks[$old_task['id']] = $new_task;

      // 2.1. Assign task to new list
      load_model("lists".DS."tasks","add");
      list_tasks__add($new_list, $new_task);

      // // 2.2 Copy subtasks
      // projects__copy_subtasks($old_task['id'], $new_task);

    endforeach;

    return $copied_tasks;
  }