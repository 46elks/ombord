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

  function projects__copy($old_project, $name = "", $title = "", $description = ""){

    if (empty($old_project)) :
      debug__log("Unable to copy project due to missing project id");
      api__response(400, "Missing project id");
    endif;

    if($title == null || $description == null || $name == null):
      // Get data from old project
      load_model("projects", "get");
      $old_project_data = projects__get($old_project);

      if($title == null) $title = $old_project_data[0]['title'];
      if($description == null) $description = $old_project_data[0]['description'];
      if($name == null) $name = $old_project_data[0]['name'];
    endif;

    // 1. Add new project
    load_model("projects", "add");
    $new_project = projects__add($name,$title,$description);

    // 2. Copy all lists that belongs to the project  
    projects__copy_lists($old_project, $new_project);

    return $new_project;

  }


  function projects__copy_lists($old_project, $new_project){
    
    // 1. Get all lists that belongs to the old project  
    load_model("projects".DS."lists","get");
    $lists = projects_lists__get($old_project);

    // 2. Copy each list
    foreach ($lists as $key => $old_list) :
      
      load_model("lists","add");
      $new_list = lists__add($old_list['title'], $old_list['description']);

      // If old list has tasks order, copy that as well
      if(!empty($old_list['tasks_order'])):
        load_model("lists","update");
        lists__update($new_list, ['tasks_order' => $old_list['tasks_order']]);
      endif;

      // 2.1 Assign new list to new project
      load_model("projects".DS."lists","add");
      projects_lists__add($new_project, $new_list);

      // 2.2 Copy old list tasks
      projects__copy_tasks($old_list['id'], $new_list);

    endforeach;

  }

  function projects__copy_tasks($old_list, $new_list){
    
    // 1. Get tasks from old list
    load_model("lists".DS."tasks","get");
    $tasks = list_tasks__get($old_list);

    // 2. Copy each task
    foreach ($tasks as $key => $old_task) :
      
      $title = (isset($old_task['title'])) ? $old_task['title'] : "";
      $description = (isset($old_task['description'])) ? $old_task['description'] : "";
      
      load_model("tasks","add");
      $new_task = tasks__add($title, $description);

      // 2.1. Assign task to new list
      load_model("lists".DS."tasks","add");
      list_tasks__add($new_list, $new_task);

      // 2.2 Copy subtasks
      projects__copy_subtasks($old_task['id'], $new_task);

    endforeach;

  }


  function projects__copy_subtasks($old_task, $new_task){

    // 1. Get all subtasks for the old task

    // 2. Copy subtasks into new task

  }