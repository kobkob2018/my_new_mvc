<h3>ניהול משימה: <?= $this->data['task_info']['title'] ?></h3>
<p>
        <a href="<?= inner_url("tasks/all/") ?>">חזרה</a>
</p>
<hr/>
<div id="task_form_wrap" class="form-gen task-form">
	<?php $this->include_view('form_builder/form.php'); ?>
</div>
