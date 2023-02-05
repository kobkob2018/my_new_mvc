<div class="controll-header">

    <div class="eject-box">
        <a class="back-link" href="<?= inner_url('users/list/') ?>">חזרה לרשימת הלקוחות</a>
    </div>

    <h3>ניהול לקוח: <?= $this->data['user_info']['full_name'] ?></h3>
    <div class="item-edit-menu">
        <a href = "<?= inner_url('users/edit/') ?>?row_id=<?= $this->data['user_info']['id'] ?>" class="item-edit-a <?= $view->a_class('users/edit/') ?>">עריכת פרטים</a>
        | 
        <a href = "<?= inner_url('users/select_cats/') ?>?row_id=<?= $this->data['user_info']['id'] ?>" class="item-edit-a <?= $view->a_class('users/select_cats/') ?>">קטגוריות</a>
        | 
        <a href = "<?= inner_url('users/select_cities/') ?>?row_id=<?= $this->data['user_info']['id'] ?>" class="item-edit-a <?= $view->a_class('users/select_cities/') ?>">ערים</a>
        | 
        <a href = "<?= inner_url('user_phones/list/') ?>?user_id=<?= $this->data['user_info']['id'] ?>" class="item-edit-a <?= $view->a_c_class('user_phones') ?>">מספרי טלפון</a>
        |
        <a href = "<?= inner_url('refund_reasons/list/') ?>?user_id=<?= $this->data['user_info']['id'] ?>" class="item-edit-a <?= $view->a_c_class('refund_reasons') ?>">סיבות זיכוי</a>
    </div>
    <hr/>

</div>