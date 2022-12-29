<div id="main_wrap" class="page-wrap">
	<div class="header page-fixed-top">
		<div id="logo_wrap" class="">
			<img src="style/image/logo.png" alt="<?= $this->data['site']['title']; ?>" />
		</div>
		
		<div class="clear"></div>	
	</div>
    <div id="page_wrap" class="row-fluid">
        <div id="right_bar_wrap" class="page-bar right-bar">
            <?php include("views/page_bars/left_bar.php"); ?>
        </div>
        <div id="right_bar_wrap" class="page-bar center-bar">
            <?php $this->call_module('system_messages','show'); ?>
            <?php $this->print_action_output(); ?>
        </div>
        <div id="left_bar_wrap" class="page-bar left-bar">
            <?php include("views/page_bars/right_bar.php"); ?>
        </div>
    </div>

	<div id="footer" class="footer">
	<?php /*
	 © כל הזכויות שומורות <a href="http://www.ilbiz.co.il" class="copyrightBottom" title="פורטל עסקים ישראל">פורטל עסקים ישראל</a>&nbsp;&nbsp;&nbsp; <a href="http://www.il-biz.com" class="copyrightBottom" target="_blank" title="IL-BIZ קידום עסקים באינטרנט">IL-BIZ קידום עסקים באינטרנט</a>&nbsp;&nbsp;&nbsp; <a href="http://kidum.ilbiz.co.il/" class="copyrightBottom" target="_blank" title="קידום באינטרנט">קידום באינטרנט</a> - אילן שוורץ&nbsp;&nbsp;&nbsp; <a href="http://www.il-biz.co.il/" class="copyrightBottom" target="_blank" title="בניית אתרים">בניית אתרים</a>
	*/ 
	?>
	<?php $this->call_module('test','help');  ?>
	</div>
</div>