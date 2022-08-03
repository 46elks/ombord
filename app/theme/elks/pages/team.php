<?php
login_required();

$team_member_id = get_team_member_id();
if($team_member_id != null):
  $user = ui__get_user($team_member_id);
else:
  $people = ui__get_users();
endif;
ui__view_fragment("head.php", ['breadcrumbs'=>ui__get_breadcrumbs("team")]);
?>

<div class="outer-wrapper">
  <div class="inner-wrapper">
    <?php if(isset($user)):
      ui__view_fragment("team-single.php", $user);
    elseif(isset($people)):
      ui__view_fragment("team-all.php", $people);
    endif;?>
  </div>
</div>

<?php if(isset($user)) ui__view_module("users", "modal-edit-user.php",$user); ?>
<?php ui__view_fragment("foot.php"); ?>