<?php 

  // =======================================
  // Breadcrumb navigation for the team page
  // =======================================

  $team_member_id = get_team_member_id();
  if($team_member_id != null):
    $user = ui__get_user($team_member_id);
    $breadcrumbs = [
       ['title' => "Ombord",'url'=>'/dashboard'],
       ['title' => "Team", 'url' => '/team'],
       ['title' => $user['firstname']],
     ];
  else:
    $breadcrumbs = [
       ['title' => "Ombord",'url'=>'/dashboard'],
       ['title' => "Team"],
     ];
  endif;

 ?>