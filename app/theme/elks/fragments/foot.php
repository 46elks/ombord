<section id="footer">
    <div class="outer-wrapper">
        <div class="inner-wrapper">
        </div>
    </div>
</section>

<?php 
    if(is_logged_in()): 
        ui__view_module("lists", "modal-move-list.php", []);
        ui__view_module("lists", "modal-copy-list.php", []);
        ui__view_module("lists", "modal-edit-list.php", []);
        ui__view_module("tasks", "modal-edit-task.php", []);

        // Load project modal only if on a single project page
        if(!empty(get_project_id()) && empty(get_task_id()) && empty(get_list_id())):
            ui__view_module("projects", "modal-edit-project.php", ui__get_project(get_project_id()));
        endif;
    endif;
?>

<script src="/js/triggers.js"></script>
</body>
</html>