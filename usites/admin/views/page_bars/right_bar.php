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
            
            
            
            <?php endif; ?>
            
            
            <?php if($view->user_is('login')): ?>
                <li class="bar-item <?= $view->a_class("userSites/list/") ?>">
                    <a href="<?= inner_url('userSites/list/') ?>" title="האתרים שלי" class="a-link">האתרים שלי</a>
                </li>
                <?php endif; ?>
                
                <?php if($view->user_is('author')): ?>
                    <li class="bar-item <?= $view->a_class("tasks/all/") ?>">
                        <a href="<?= inner_url('tasks/all/') ?>" title="המשימות שלי" class="a-link">המשימות שלי</a>
            </li>
            <?php endif; ?>
            

            
            <?php if($view->user_is('master_admin')): ?>
                <li class="bar-item <?= $view->a_class("siteUsers/list/") ?>">
                <a href="<?= inner_url('siteUsers/list/') ?>" title="מנהלי אתר" class="a-link">מנהלי אתר</a>
            </li>        
        <?php endif; ?>

    </ul>

    <?php if($view->user_is('admin')): ?>
        <h4>ניהול תפריטים</h4>
        <ul class="item-group">

            <li class="bar-item <?= $view->a_class("menus/right_menu/") ?>">
                <a href="<?= inner_url('menus/right_menu/') ?>" title="תפריט ימני" class="a-link">תפריט ימני</a>
            </li>
            <li class="bar-item <?= $view->a_class("menus/top_menu/") ?>">

                <a href="<?= inner_url('menus/top_menu/') ?>" title="תפריט עליון" class="a-link">תפריט עליון</a>
            </li>
            <li class="bar-item <?= $view->a_class("menus/bottom_menu/") ?>">
       
                <a href="<?= inner_url('menus/bottom_menu/') ?>" title="תפריט תחתון" class="a-link">תפריט תחתון</a>
            </li>
            <li class="bar-item <?= $view->a_class("menus/hero_menu/") ?>">
       
                <a href="<?= inner_url('menus/hero_menu/') ?>" title="תפריט הירו" class="a-link">תפריט הירו</a>
            </li>           
        </ul>

        <ul class="item-group">

            <li class="bar-item <?= $view->a_class("pages/list/") ?> <?= $view->a_c_class("pages") ?>">
                <a href="<?= inner_url('pages/list/') ?>" title="דפים באתר" class="a-link">דפים באתר</a>
            </li>
            <?php if($view->controller_is("pages")): ?>
                <li class="bar-item <?= $view->a_class("pages/add/") ?>">
                    <a href="<?= inner_url('pages/add/') ?>" title="דף חדש" class="a-link">דף חדש</a>
                </li>
                <li class="bar-item <?= $view->a_class("pages/dir_list/") ?>">
                    <a href="<?= inner_url('pages/dir_list/') ?>" title="רשימת תיקיות" class="a-link">רשימת תיקיות</a>
                </li>
                <li class="bar-item <?= $view->a_class("pages/dir_add/") ?>">
                    <a href="<?= inner_url('pages/dir_add/') ?>" title="הוספת תיקייה" class="a-link">הוספת תיקייה</a>
                </li>
            <?php endif; ?>          
        </ul>
    <?php endif; ?>
</div>