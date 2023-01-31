
<div class="eject-box">
    <a class="back-link" href="<?= inner_url('pages/list/') ?>">חזרה</a>
</div>

<h3>ניהול דף: <?= $this->data['page_info']['title'] ?></h3>
<div class="item-edit-menu">
    <a href = "<?= inner_url('pages/edit/') ?>?row_id=<?= $this->data['page_info']['id'] ?>" class="item-edit-a <?= $view->a_c_class('pages') ?>">ראשי</a>
     | 
     <a href = "<?= inner_url('blocks/list/') ?>?page_id=<?= $this->data['page_info']['id'] ?>" class="item-edit-a <?= $view->a_c_class('blocks') ?>">בלוקים</a>
     | 
     <a href = "<?= inner_url('biz_forms/list/') ?>?page_id=<?= $this->data['page_info']['id'] ?>" class="item-edit-a <?= $view->a_c_class('biz_forms') ?>">ניהול טופס</a>
</div>
<hr/>