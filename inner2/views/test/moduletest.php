<div  class="message error-message">
    <?php foreach($this->data['testparams'] as $key=>$val): ?>
        <div>
            <h3><?php echo $key; ?></h3>
                <?php echo $val; ?>
        </div>
    <?php endforeach; ?>
    
</div>

<div>
    <h2>nesting module here HIIII</h2>
    <div><?php $this->call_module('test','nesting_module'); ?></div>
</div>