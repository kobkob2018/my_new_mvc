<h3>ניהול משימה: <?= $this->data['item_info']['title'] ?></h3>
<p>
        <a href="<?= inner_url("tasks/list/") ?>">חזרה</a>
</p>
<hr/>
<div id="task_form_wrap" class="form-gen task-form">
	<?php $this->include_view('form_builder/form.php'); ?>
</div>
