<?php $lists = $module; ?>

<section id="lists">
  <div class="js-list-parent">
    <?php foreach ($lists as $key => $list) :
      $list['items'] = ui__get_sorted_tasks($list['id'],$list['tasks_order']);
      ui__view_module("lists", "list-tasks.php", $list);
    endforeach;?>
  </div>
  <br>
  <br>
  <br>
  <?php if(is_admin()) ui__view_module("lists", "form-add-list.php", []);?>
</section>

<?php ui__view_module("lists", "template-new-list.php", []);?>