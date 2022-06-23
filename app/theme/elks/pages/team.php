<?php
login_required();

$team_member_id = get_team_member_id();
if($team_member_id != null):
  $user = ui__get_user($team_member_id);
  $breadcrumbs = [
     ['title' => "Ombord",'url'=>'/dashboard'],
     ['title' => "Team", 'url' => '/team'],
     ['title' => $user['firstname']],
   ];
else:
  $people = ui__get_users();
  shuffle($people);
  $breadcrumbs = [
     ['title' => "Ombord",'url'=>'/dashboard'],
     ['title' => "Team"],
   ];
endif;
ui__view_fragment("head.php", ['breadcrumbs'=>$breadcrumbs]);
?>

<div class="outer-wrapper">
  <div class="inner-wrapper">
    <?php if(isset($user)):
      ui__view_fragment("team-single.php", $user);
    else:
      ui__view_fragment("team-all.php", $people);
    endif;?>

  </div>
</div>

<?php ui__view_fragment("foot.php"); ?>