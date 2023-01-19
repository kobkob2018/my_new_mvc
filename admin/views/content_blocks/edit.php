<?php $this->include_view("content_pages/header.php"); ?>
<div class="focus-box">
    <p>
        <a href="<?= $this->eject_url() ?>">חזרה</a>
    </p>
    <h3>עריכת בלוק <?= $this->data['item_info']['label'] ?></h3>
    <hr/>
    <div id="block_form_wrap" class="form-gen page-form">
        <?php $this->include_view('form_builder/form.php'); ?>
    </div>
</div>
