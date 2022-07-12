<?php 

    // ===================================================
    // Breadcrumb navigation for projects, lists and tasks.
    // ===================================================

    $breadcrumbs = [];

    if (!empty(get_task_id())) :
      $task = ui__get_task(get_task_id());
      array_push($breadcrumbs, ['title' => substr($task['title'],0,20)."..."]);
      unset($task);
    endif;

    if (!empty(get_list_id())) :
      $list = ui__get_list(get_list_id());
      if(empty($breadcrumbs)):
        array_unshift($breadcrumbs, ['title' => $list['title']]);
      else:
        array_unshift($breadcrumbs, ['title' => $list['title'], 'url' => ui__get_list_url(get_list_id())]);
      endif;
      unset($list);
    endif;

    if (!empty(get_project_id())) :
      $project = ui__get_project(get_project_id());
      if(empty($breadcrumbs)):
        array_unshift($breadcrumbs, ['title' => $project['name']]);
      else:
        array_unshift($breadcrumbs, ['title' => $project['name'], 'url' => ui__get_project_url(get_project_id())]);
      endif;
      unset($project);
    endif;

    if(empty($breadcrumbs)):
      array_unshift($breadcrumbs, ['title' => "Ombord"]);
    else:
      array_unshift($breadcrumbs, ['title' => "Ombord", 'url' => "/dashboard"]);
    endif;

    
?>
