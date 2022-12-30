<div id="page_wrap" class="page-wrap">
	<div class="header">
		<div id="logo_wrap" class="">
			<img src="style/image/logo.png" alt="מערכת הלידים של איי-אל-ביז" />
		</div>	
		<?php if($this->user): ?>

			<div id="header_usermenu_wrap">
				hello <?= $this->user['full_name']; ?>
				<?php $this->call_module('user_sites','raff_list');  ?>
				<ul>
					<li><a href="<?= inner_url("userSites/list/") ?>">האתרים שלי</a></li>
					<li><a href="<?= inner_url("user/details/") ?>">עדכון פרטים</a></li>
					<li><a href="<?= inner_url("userLogin/logout/") ?>">יציאה</a></li>
				</ul>

			</div>
			
		<?php else: ?>
		  <a href = "<?= inner_url("userLogin/login/"); ?>">כניסה למערכת</a> | 
		  <a href = "<?= inner_url("userLogin/register/"); ?>">הרשמה</a> | 
		  <a href = "<?= inner_url(""); ?>">דף הבית</a>
		<?php endif; ?>
		
		<?php $this->call_module('system_messages','show'); ?>
		<div class="clear"></div>	
	</div>
	
	<div id="content_wrap">
		<?php $this->print_action_output(); ?>
	</div>
	<div id="footer" class="footer">
	<?php /*
	 © כל הזכויות שומורות <a href="http://www.ilbiz.co.il" class="copyrightBottom" title="פורטל עסקים ישראל">פורטל עסקים ישראל</a>&nbsp;&nbsp;&nbsp; <a href="http://www.il-biz.com" class="copyrightBottom" target="_blank" title="IL-BIZ קידום עסקים באינטרנט">IL-BIZ קידום עסקים באינטרנט</a>&nbsp;&nbsp;&nbsp; <a href="http://kidum.ilbiz.co.il/" class="copyrightBottom" target="_blank" title="קידום באינטרנט">קידום באינטרנט</a> - אילן שוורץ&nbsp;&nbsp;&nbsp; <a href="http://www.il-biz.co.il/" class="copyrightBottom" target="_blank" title="בניית אתרים">בניית אתרים</a>
	*/ 
	?>
	
	<?php $this->call_module('test','help');  ?>
	</div>
</div>