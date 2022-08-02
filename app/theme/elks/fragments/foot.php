<section id="footer">
    <div class="outer-wrapper">
        <div class="inner-wrapper">
        </div>
    </div>
</section>

<?php ui__view_module("lists", "modal-edit-list.php", []); ?>
<?php ui__view_module("tasks", "modal-edit-task.php", []); ?>

<?php 
    // Load porject modal only if on a single project page
    if(!empty(get_project_id()) && empty(get_task_id()) && empty(get_list_id())):
        ui__view_module("projects", "modal-edit-project.php", ui__get_project(get_project_id()));
    endif;
 ?>

<script src="/js/triggers.js"></script>
</body>
</html>