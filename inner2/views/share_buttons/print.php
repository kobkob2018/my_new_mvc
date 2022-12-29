ca you see the share buttons?
<?php if(isset($this->data['share_buttons']['whatsapp'])): ?>xxx
    <a href="<?= $this->data['share_buttons']['whatsapp']['href']; ?>">
        <img width="30px;" src="<?= $this->data['share_buttons']['whatsapp']['img']; ?>" alt="">
    </a>
<?php endif; ?>