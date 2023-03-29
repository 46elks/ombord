<?php 

  /* -------------------------------
   ------------------------------- */

  /**
   * Copy a list to a different project
   *
   * @param $old_project_id (int) - required
   * @param $new_project_id (int) - required
   * @param $list_id (int) - required
   *
   * @return int (id of row) or false
   *
   */

  function projects_lists__copy($old_project, $list_id, $new_project = null){
    
    if($new_project == null) $new_project = $old_project;

    // 1. Get all lists that belongs to the old project  
    load_model("lists","get");
    $old_list = lists__get($list_id);
    
    if(empty($old_list))
      api__response(404, "List not found");

    $old_list = $old_list [0];
    
    // 2. Copy list
    load_model("lists","add");
    $new_list_id = lists__add($old_list['title']." (copy)", $old_list['description']);

    // If old list has tasks order, copy that as well
    if(!empty($old_list['tasks_order'])):
      load_model("lists","update");
      lists__update($new_list_id, ['tasks_order' => $old_list['tasks_order']]);
    endif;

    // 2.1 Assign the new list to the new project
    load_model("projects".DS."lists","add");
    projects_lists__add($new_project, $new_list_id);

    // 2.2 Copy old list tasks
    load_model("lists".DS."tasks","copy");
    lists_tasks__copy($old_list['id'], $new_list_id);

    return $new_list_id;

  }