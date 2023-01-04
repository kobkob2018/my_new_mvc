<h2><?= $this->data['page_title'] ?></h2>
<?php if($this->data['main_menu_item']): ?>
    <h3>רשימת תתי תפריט לקישור - <?= $this->data['main_menu_item']['title'] ?></h3>
<?php endif; ?>



<div class="items-table flex-table">
    <div class="table-th row">
        <div class="col col-first col-tiny">מיקום</div>
        <div class="col">תווית</div>
        <div class="col">סוג הקישור</div>
        <div class="col">כתובת הקישור</div>
        <div class="col">קישור לדף</div>
        <div class="col">ייפתח ב</div>
        <div class="col col-small">תווית עיצוב</div>
        <div class="col">שמירה</div>
        <div class="col">מחיקה</div>
    </div>

    <?php foreach($this->data['menu_item_list'] as $menu_item): ?>
        <form  class="table-th row" action = "" method = "POST" >
            <input type="hidden" name="sendAction" value="updateSend" />
            <input type="hidden" name="row_id" value="<?= $menu_item['id'] ?>" />    
            <div class="col col-first col-tiny">                   
                <input type="text" class = 'table-input' name = 'row[priority]' value = '<?= $this->get_form_input('priority',$menu_item['form_identifier']) ?>' />
            </div>
            <div class="col">
                <input type="text" class = 'table-input' name = 'row[title]' value = '<?= $this->get_form_input('title',$menu_item['form_identifier']) ?>' />
            </div>
            <div class="col">
                <select name='row[link_type]' class='table-select'>
                    <?php foreach($this->get_select_options('link_type',$menu_item['form_identifier']) as $option): ?>
                        <option value="<?= $option['value'] ?>" <?= $option['selected'] ?>><?= $option['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col">
                <input type="text" class = 'table-input' name = 'row[url]' value = '<?= $this->get_form_input('url',$menu_item['form_identifier']) ?>' />
            </div>
            <div class="col">
                <select name='row[page_id]' class='table-select'>
                    <?php foreach($this->get_select_options('page_id',$menu_item['form_identifier']) as $option): ?>
                        <option value="<?= $option['value'] ?>" <?= $option['selected'] ?>><?= $option['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col">
                <select name='row[target]' class='table-select'>
                    <?php foreach($this->get_select_options('target',$menu_item['form_identifier']) as $option): ?>
                        <option value="<?= $option['value'] ?>" <?= $option['selected'] ?>><?= $option['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col col-small">
                <input type="text" class = 'table-input' name = 'row[css_class]' value = '<?= $this->get_form_input('css_class',$menu_item['form_identifier']) ?>' />
            </div>
            <div class="col"><input type="submit" value="שמור" /></div>
            <div class="col">
                <a href="<?= current_url(array('delete'=>$menu_item['id'])) ?>">
                    מחיקה
                </a>
            </div>
           
        </form>
    <?php endforeach; ?>

</div>
        