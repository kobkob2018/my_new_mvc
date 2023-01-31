<?php $this->include_view("net_directories/header.php"); ?>
<div class="focus-box">
    <div class="eject-box">
        <a href="<?= $this->eject_url() ?>">חזרה לרשימת הבאנרים בתיקייה</a>
    </div>
    <hr/>
    <?php $this->include_view("net_banners/sub_header.php"); ?>
    <div id="block_form_wrap" class="form-gen page-form">
        <h4>בחר קטגוריות</h4>
        <div class="cat-select-form-wrap">

            <form name="send_form" class="send-form form-validate" id="send_form" method="post" action="">
                <input type="hidden" name="sendAction" value="set_categoriesSend" />
                <?php foreach($this->data['category_tree']['children'] as $cat_item): ?>
                    <?php $this->add_recursive_cat_select_view($cat_item); ?>
                <?php endforeach; ?>

                <div class="submit-wrap">
                    <button type = "submit">שליחה</button>
                </div>
            </form>
        </div>
    </div>
</div>
