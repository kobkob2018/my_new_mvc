<div id="page_wrap" class="container">
	<div class="header">
		<?php $this->call_module('test','help');  ?>
		<div id="logo_wrap">
			<img src="style/image/logo.png" alt="מערכת הלידים של איי-אל-ביז" />
		</div>		
		<div class="clear"></div>	
	</div>
	<div class="header-space-keeper"></div>
	<div id="content_wrap">
		<h3>messeges here:</h3>
		<?php $this->call_module('system_messages','show');  ?>
		
		<?php $this->print_action_output(); ?>
	</div>
	<div id="footer" class="footer">
	
		<a href=" http://cms.ilbiz.co.il/" target="_BLANK" class="copyrightBottom" title="מדריך לניהול מערכת לידים">מדריך לניהול מערכת לידים</a>
		
	</div>
</div>