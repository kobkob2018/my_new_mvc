<?php $this->include_view("cities/city_header.php"); ?>

<?php $this->include_view("crud/item_move_block.php"); ?>


<?php if(isset($this->data['move_item'])): ?>
    <div class="move-item-button-wrap">
        <a class='go-button' href="<?= inner_url('cities/list/') ?>?item_id=<?= $this->data['current_item_id'] ?>&move_item=here">העבר לכאן</a>
    </div>
<?php else: ?>
    <div class="add-button-wrap">
        <a class="button-focus" href="<?= inner_url('cities/add/') ?>?item_id=<?= $this->data['current_item_id'] ?>">הוספת עיר\אזור</a>
    </div>
<?PHP endif; ?>


<?php if(!empty($this->data['city_list'])): ?>
    <div class="items-table flex-table">
        <div class="table-th row">
            <div class="col">שם</div>
            <div class="col">סוג</div>
            <div class="col">עריכה</div>
            <div class="col">העברה</div>
            <div class="col">מחיקה</div>
        </div>
        <?php foreach($this->data['city_list'] as $city): ?>
            <div class="table-tr row">
                <div class="col">
                    <a href = "<?= inner_url('cities/list/') ?>?item_id=<?= $city['id'] ?>" title="בחירה"><?= $city['label'] ?></a>
                </div>
                <div class="col">
                    <a href = "<?= inner_url('cities/edit/') ?>?row_id=<?= $city['id'] ?>" title="עריכה">עריכה</a>
                </div>
                <div class="col">

                    <?php if(isset($this->data['move_item'])): ?>
                        <a class='go-button' href="<?= inner_url('cities/list/') ?>?item_id=<?= $city['id'] ?>&move_item=here">העבר לכאן</a>
                    <?php else: ?>

                        <a href = "<?= inner_url('cities/list/') ?>?move_item=<?= $city['id'] ?>" title="העברה">העברה</a>
                    <?PHP endif; ?>
                
                
                </div>
                <div class="col">
                    <a href = "<?= inner_url('cities/delete/') ?>?row_id=<?= $city['id'] ?>" title="מחק">מחק</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <h4>אין תתי ערים</h4>
<?php endif; ?>