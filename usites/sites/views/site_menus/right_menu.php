<ul class="item-group right-menu">
    
    <?php if($this->data['right_menu_items']['root_items']): ?>
        <?php foreach($this->data['right_menu_items']['root_items'] as $menu_item): ?>
            <li class="bar-item <?= $menu_item['css_class'] ?>">
                <?php if($menu_item['link_type'] != '2'): ?>
                    <a href="<?= $menu_item['final_url'] ?>" target="<?= $menu_item['target'] ?>" title="<?= $menu_item['title'] ?>" class="a-link"><?= $menu_item['title'] ?></a>
                <?php else: ?>
                    <b class='group-menu-item'><?= $menu_item['title'] ?></b>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
    <?php if($this->data['right_menu_items']['child_items']): ?>
        <?php foreach($this->data['right_menu_items']['child_items'] as $menu_item): ?>
            <li class="bar-item <?= $menu_item['css_class'] ?>">
                <?php if($menu_item['link_type'] != '2'): ?>
                    <a href="<?= $menu_item['final_url'] ?>" target="<?= $menu_item['target'] ?>" title="<?= $menu_item['title'] ?>" class="a-link"><?= $menu_item['title'] ?></a>
                <?php else: ?>
                    <b class='group-menu-item'><?= $menu_item['title'] ?></b>
                <?php endif; ?>    
            </li>
        <?php endforeach; ?>    
    <?php endif; ?>   
</ul>