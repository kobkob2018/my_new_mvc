<ul>
    <?php if(!$this->user): ?>
        <a href = "<?= inner_url("userLogin/login/"); ?>" class="a-link <?= $view->a_class("userLogin/login/") ?>">כניסה למערכת</a> | 
		<a href = "<?= inner_url("userLogin/register/"); ?>" class="a-link <?= $view->a_class("userLogin/register/") ?>">הרשמה</a> |      
    <?php endif; ?>
    <?php if($view->user_is('login')): ?>
        <div id="header_usermenu_wrap">
            hello <?= $this->user['full_name']; ?>
            <ul>
                <li><a href="<?= inner_url("user/details/") ?>" class="a-link <?= $view->a_class("user/details/") ?>">עדכון פרטים</a></li>
                <li><a href="<?= inner_url("userLogin/logout/") ?>" class="a-link">יציאה</a></li>
            </ul>

        </div>
        
    <?php endif; ?>


    <?php if($view->user_is('login')): ?>
        <li>
            <a href="<?= inner_url('userSites/list/') ?>" title="האתרים שלי" class="a-link <?= $view->a_class("userSites/list/") ?>">האתרים שלי</a>
        </li>
    <?php endif; ?>
    
    <?php if($view->user_is('author')): ?>
        <li>
            <a href="<?= inner_url('tasks/all/') ?>" title="המשימות שלי" class="a-link <?= $view->a_class("tasks/all/") ?>">המשימות שלי</a>
        </li>
    <?php endif; ?>

    <?php if($view->user_is('master_admin')): ?>
        <li>
            <a href="<?= inner_url('siteUsers/list/') ?>" title="מנהלי אתר" class="a-link <?= $view->a_class("siteUsers/list/") ?>">מנהלי אתר</a>
        </li>        
    <?php endif; ?>

</ul>
