<div class = "cat-checkbox-parent-wrap <?= $info['item']['open_class'] ?>" >
    <div class="checkbox-head">
        <span class='a-gap'>
            <?php if($info['item']['has_children']): ?>
                <a class = "a-door a-gap a-<?= $info['item']['open_class'] ?>" href = "javascript://" onclick="cat_select_toggle(this)" data-cat_id = <?= $info['item']['id'] ?>>
                        
                    <span class="replacable-plus-sign">+</span>
                    <span class="replacable-minus-sign">-</span>
                </a>       
            <?php endif; ?>
        </span>
        <span class="check-label">

            <input class="input-checkbox" type = "checkbox" name = "cat[<?= $info['item']['id'] ?>]" <?= $info['item']['checked']? 'checked': '' ?> /> <?= $info['item']['label'] ?>
        </span>
    </div>
    <?php if($info['item']['has_children']): ?>
        <div class="children-wrap child-of-<?= $info['item']['id'] ?>">
            
            <?php foreach($info['item']['children'] as $cat_item): ?>
                <?php $this->add_recursive_cat_select_view($cat_item); ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>