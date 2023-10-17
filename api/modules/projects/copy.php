<?php 

/* -------------------------------
   ------------------------------- */

  /**
   * Add new project
   *
   * @param $title (string) - required
   * @param $description (string) - optional
   *
   * @return int (id of row) or false
   *
   */

  function projects__copy($old_project_id, $name = "", $title = "", $description = ""){

    if (empty($old_project_id)) :
      debug__log("Unable to copy project due to missing project id");
      api__response(400, "Missing project id");
    endif;

    // Get data from old project
    load_model("projects", "get");
    $old_project_data = projects__get($old_project_id);
    
    if($title == null) $title = $old_project_data[0]['title'];
    if($description == null) $description = $old_project_data[0]['description'];
    if($name == null) $name = $old_project_data[0]['name'];

    // 1. Add new project
    load_model("projects", "add");
    $new_project_id = projects__add($name, $title, $description);

    // 2. Copy all lists that belongs to the project  
    load_model("projects".DS."lists","get");
    $lists = projects_lists__get($old_project_id);

    if(!empty($old_project_data[0]['lists_order'])):
      // Sort the lists to ensure that the new project get the lists
      // in the same order as the old project
      $lists = sort_items($lists, $old_project_data[0]['lists_order']);
    endif;

    projects__copy_lists($lists, $new_project_id);

    return $new_project_id;

  }


  function projects__copy_lists($lists, $project_id){

    // Ensure no task is copied twice. 
    // That could happend for tasks that are 
    // assigned to mulitple lists (a.k.a linked tasks)
    $copied_tasks = [];
    
    // 2. Copy each list
    foreach ($lists as $key => $old_list) :
      
      load_model("lists","add");
      $new_list_id = lists__add($old_list['title'], $old_list['description']);

      // If old list has tasks order, copy that as well
      if(!empty($old_list['tasks_order'])):
        load_model("lists","update");
        lists__update($new_list_id, ['tasks_order' => $old_list['tasks_order']]);
      endif;

      // 2.1 Assign new list to new project
      load_model("projects".DS."lists","add");
      projects_lists__add($project_id, $new_list_id);

      // 2.2 Copy old list tasks
      $copied_tasks = projects__copy_tasks($old_list['id'], $new_list_id, $copied_tasks);

    endforeach;

  }

  
  function projects__copy_tasks($old_list, $new_list, $copied_tasks = array()){
    
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

      // 2.2 Copy subtasks
      projects__copy_subtasks($old_task['id'], $new_task);

    endforeach;

    return $copied_tasks;
  }


  function projects__copy_subtasks($old_task, $new_task){

    // 1. Get all subtasks for the old task

    // 2. Copy subtasks into new task

  }