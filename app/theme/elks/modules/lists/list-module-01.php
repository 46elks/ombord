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

<script>

  // // ========
  // // Add list
  // // ========
  // let formAddList = document.getElementById('form-add-list');
  // if(formAddList){
  //   formHandler.init(formAddList,function(data){
  //     app.log("New list created");
  //     console.log(data);
  //     formAddList.querySelector('#new-list-field').value = "";
  //     let listElement = document.getElementById('new-list-template');
  //     let parentElement = document.querySelector('.js-list-parent');
  //     renderList(data, listElement, parentElement);
  //   });
  // }

  // ========
  // Bind list events
  // ========
  // let lists = document.querySelectorAll('.js-list-wrapper');
  // if(lists){
  //   for (var i = lists.length - 1; i >= 0; i--) {
  //     bindListEvents(lists[i]);
  //   }  
  // }


</script>