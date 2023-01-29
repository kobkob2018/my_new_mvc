<div id = "right_bar">
    <?php if($view->user_is('login')): ?>
        <h4>hello <?= $this->user['full_name']; ?></h4>
    <?php endif; ?>
    <ul class="item-group">
        <?php if(!$this->user): ?>
            <li class="bar-item  <?= $view->a_class("userLogin/login/") ?>"">
                <a href = "<?= inner_url("userLogin/login/"); ?>" class="a-link <?= $view->a_class("userLogin/login/") ?>">כניסה למערכת</a>
            </li>
            <li class="bar-item  <?= $view->a_class("userLogin/register/") ?>">
                <a href = "<?= inner_url("userLogin/register/"); ?>" class="a-link <?= $view->a_class("userLogin/register/") ?>">הרשמה</a> 
            </li>
        <?php endif; ?>
        <?php if($view->user_is('login')): ?>
            
            
            
            <li class="bar-item <?= $view->a_class("user/details/") ?>"><a href="<?= inner_url("user/details/") ?>" class="a-link">עדכון פרטים</a></li>
            <li class="bar-item"><a href="<?= inner_url("userLogin/logout/") ?>" class="a-link">יציאה</a></li>
            
            <li class="bar-item <?= $view->a_class("tasks/list/") ?>">
                <a href="<?= inner_url('tasks/list/') ?>" title="המשימות שלי" class="a-link">המשימות שלי</a>
            </li>            
            
        <?php endif; ?>
                
        <?php if($view->user_is('master_admin')): ?>
            <li class="bar-item <?= $view->a_c_class("biz_categories") ?>">
                <a href="<?= inner_url('biz_categories/list/') ?>" title="ניהול קטגוריות בפורטל" class="a-link">ניהול קטגוריות</a>
            </li> 
        <?php endif; ?>

    </ul>
</div>