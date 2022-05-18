<?php
login_required();
if(isset($_GET['id'])):
  $id = (isset($_GET['id'])) ? $_GET['id'] : get_user_id();
  $user = ui__get_user($id);
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