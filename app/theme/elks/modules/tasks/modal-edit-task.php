<div id="modal-task-update" class="js-modal modal hidden">
  <div class="modal__content">
    <h2 class="text-center">Redigera uppgiften</h2>
    <?php ui__view_module("tasks", "form-edit-task.php", []);?>

    <?php if(!empty(get_task_id())): ?>
      <?php $task_id = get_task_id(); ?>
      <?php 
        // Get all lists that exists within the project 
        // and put a mark on the lists which the task is assigned to
        $lists = ui__get_lists(null, ["project_id" => get_project_id(), 'task_id' => $task_id]);
      ?>
      <br>
      <h2>Projektlistor</h2>
      <p class="preamble">Lägg till eller ta bort uppgiften från de listor som är tillgängliga i projektet.</p>
      <ul class="block-list checkbox-list">
        <?php foreach($lists as $key => $list): ?>
          <?php $checked = ((bool)$list['is_chosen']) ? "checked" : ""; ?>
          <li>
            <input type="checkbox" <?=$checked;?> onclick="toggleListTask(<?=$task_id;?>,<?=$list['id'];?>, this.checked, null);">
            <span><?=$list['title'];?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

  </div>
</div>