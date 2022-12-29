<div id="content_title_wrap">
    <h1 id="content_title"><?= $this->data['page']['title']; ?></h1>
    <div id="share_buttons_wrap">
        <?php $this->call_module('share_buttons','print'); ?>
    </div>
</div>
<div id="content_wrap">
    <?= $this->data['page']['content']; ?>
</div>