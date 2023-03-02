<div id = "right_bar">

    <?php if($view->user_is('login')): ?>
        <h4>hello <?= $this->user['full_name']; ?></h4>
    <?php endif; ?>

    <h4>Here will be filter and more</h4>
</div>