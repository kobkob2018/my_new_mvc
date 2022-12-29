<ul>
    <?php foreach($this->data['user_sites_link_list'] as $site): ?>
        <li>
            <a href="http://<?= $site['domain']; ?>/usites/" title="<?= $site['title']; ?>"><?= $site['title']; ?></a>
        </li>
    <?php endforeach; ?>
    <li>
        <a href="http://love.com/usites/" title="אתר ספינת האהבה">גישה זמנית לאתר love.com</a>
    </li>
</ul>

