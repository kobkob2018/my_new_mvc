<a class="back-link" href="<?= inner_url('pages/list/') ?>">חזרה</a>
<h3>ניהול דף: <?= $this->data['page_info']['title'] ?></h3>
<div class="item-edit-menu">
    <a href = "<?= inner_url('pages/edit/') ?>?row_id=<?= $this->data['page_info']['id'] ?>" class="item-edit-a <?= $view->a_class('pages/edit/') ?>">ראשי</a>
     | 
     <a href = "<?= inner_url('blocks/list/') ?>?page_id=<?= $this->data['page_info']['id'] ?>" class="item-edit-a <?= $view->a_class('blocks/list/') ?>">בלוקים</a>
     | 
     <a href = "<?= inner_url('blocks/list/') ?>?page_id=<?= $this->data['page_info']['id'] ?>" class="item-edit-a <?= $view->a_class('blocks/list/') ?>">ניהול טופס</a>
</div>
<hr/>