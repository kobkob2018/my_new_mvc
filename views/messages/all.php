<?php if(!empty($this->data['err_messages'])){ ?>
	<div class="messages error-messages">
		<?php foreach($this->data['err_messages'] as $message){ ?>
			<?php include('views/messages/errorMessage.php'); ?>
		<?php } ?>
	</div>
<?php } ?>
<?php if(!empty($this->data['success_messages'])){ ?>
	<div  class="messages success-messages">
		<?php foreach($this->data['success_messages'] as $message){ ?>
			<?php include('views/messages/successMessage.php'); ?>
		<?php } ?>
	</div>
<?php } ?>
