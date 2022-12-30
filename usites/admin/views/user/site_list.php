<ul> 
    <?php foreach($this->data['user_sites_link_list'] as $site): ?>
        <li>
            <a href="<?= inner_url("userSites/checkin/") ?>?workon=<?= $site['id'] ?>" title="<?= $site['title']; ?>"><?= $site['title']; ?></a>
             | 
             <a href="http://<?= $site['domain']; ?>/usites/" title="<?= $site['title']; ?>" target="_BLANK">צפה באתר</a>
        </li>
    <?php endforeach; ?>
    <li>
        <a href="http://love.com/usites/" title="אתר ספינת האהבה">גישה זמנית לאתר love.com</a>
    </li>
</ul>

