<?php $this->include_view("content_pages/header.php"); ?>
<h3>בלוק חדש</h3>
<p>
        <a href="<?= $this->eject_url() ?>">חזרה</a>
</p>
<hr/>
<div id="block_form_wrap" class="form-gen page-form">
	<?php $this->include_view('form_builder/form.php'); ?>
</div>
