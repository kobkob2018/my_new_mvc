<?php if($this->data['top_menu_items']): ?>
    <ul class="item-group top-menu">
        
        
            <?php foreach($this->data['top_menu_items'] as $menu_item): ?>
                <li class="bar-item <?= $menu_item['css_class'] ?>">
                    <?php if($menu_item['link_type'] != '2'): ?>
                        <a href="<?= $menu_item['final_url'] ?>" target="<?= $menu_item['target'] ?>" title="<?= $menu_item['title'] ?>" class="a-link"><?= $menu_item['title'] ?></a>
                    <?php else: ?>
                        <b class='group-menu-item'><?= $menu_item['title'] ?></b>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        
    </ul>
<?php endif; ?>