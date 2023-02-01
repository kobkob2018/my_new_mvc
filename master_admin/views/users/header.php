<div class="eject-box">
    <a class="back-link" href="<?= inner_url('users/list/') ?>">חזרה</a>
</div>

<h3>ניהול לקוח: <?= $this->data['user_info']['full_name'] ?></h3>
<div class="item-edit-menu">
    <a href = "<?= inner_url('users/edit/') ?>?row_id=<?= $this->data['user_info']['id'] ?>" class="item-edit-a <?= $view->a_class('users/edit/') ?>">עריכת פרטים</a>
     | 
     <a href = "<?= inner_url('users/select_cats/') ?>?row_id=<?= $this->data['user_info']['id'] ?>" class="item-edit-a <?= $view->a_class('users/select_cats/') ?>">קטגוריות</a>
     | 
     <a href = "<?= inner_url('users/select_cities/') ?>?row_id=<?= $this->data['user_info']['id'] ?>" class="item-edit-a <?= $view->a_class('users/select_cities/') ?>">ערים</a>
</div>
<hr/>