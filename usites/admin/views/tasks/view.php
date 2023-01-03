<h3>ניהול משימה: <?= $this->data['task_info']['title'] ?></h3>
<p>
        <a href="<?= inner_url("tasks/all/") ?>">חזרה</a>
</p>
<hr/>
<div id="task_form_wrap" class="form-gen task-form">
    <?php $this->include_view('messages/formMessages.php'); ?>
	<form name="send_form" class="send-form form-validate" id="send_form" method="post" action=""  enctype="multipart/form-data">
		<input type="hidden" name="sendAction" value="updateSend" />
        <input type="hidden" name="row_id" value="<?= $this->data['task_info']['id'] ?>" />
		<div class="row-fluid">	

            <div class="form-group span3">
				<label for="row[email]">אימייל</label>
                <input type="text" name="row[email]" id="email" class="form-input required email" data-msg-required="*" value="<?= $this->get_form_input("email"); ?>"  />
               
			</div>	
            <div class="form-group span3">
				<label for="row[phone]">טלפון</label>
                <input type="text" name="row[phone]" id="user_id" class="form-input required phone" data-msg-required="*" value="<?= $this->get_form_input("phone"); ?>"  />
               
			</div>	

            <div class="form-group span3">
				<label for="row[title]">כותרת</label>
                <input type="text" name="row[title]" id="row_title" class="form-input required" data-msg-required="*" value="<?= $this->get_form_input("title"); ?>"  />
               
			</div>	
			



            <div class="form-group span3">
				<label for="row[description]">תיאור</label>
                <textarea name="row[description]" id="task_content_textarea" class="form-input" data-msg-required="*"><?= $this->get_form_input("description"); ?></textarea>
               
			</div>	

			<div class="form-group span3">
				<label for="row[banner]">באנר</label>
                <input type="file" name="row[banner]" id="task_banner_file" class="form-input" data-msg-required="*" value="" />
				<?php if($banner_url = $this->get_form_file_url('banner')): ?>
					<div>

						<a href="<?= $banner_url ?>" target="_BLANK">
							<img src='<?= $banner_url ?>?cache=<?= rand() ?>'  style="max-width:200px;"/>
						</a>
						<br/>
						<a href="<?= current_url() ?>&remove_file=banner">הסר באנר</a>
					</div>
				<?php endif; ?>
				
				
			</div>	

		</div>
		<hr/>
		<div class="row-fluid">		

			<div class="form-group span3">
				<b>פרטים נוספים</b>
			</div>	
		</div>		
		<div class="row-fluid">	
            
			<div class="form-group span3">
				<label for="row[user_id]">שיוך למספר משתמש</label>

                <select  id='row_user_id' name='row[user_id]' class='form-select user_id-row input_style' data-msg="יש לבחור משתמש">
                    <?php foreach($this->get_select_options('user_id') as $option): ?>
                        <option value="<?= $option['value'] ?>" <?= $option['selected'] ?>><?= $option['title'] ?></option>
                    <?php endforeach; ?>
                </select>
				
            </div>

			<div class="form-group span3">
				<label for="row[status]">סטטוס פעיל</label>

                <select  id='row_status' name='row[status]' class='form-select status-row input_style' data-msg="יש לבחור סטטוס">
                    <?php foreach($this->get_select_options('status') as $option): ?>
                        <option value="<?= $option['value'] ?>" <?= $option['selected'] ?>><?= $option['title'] ?></option>
                    <?php endforeach; ?>
                </select>
				
            </div>

			<div class="form-group span3">
				<label for="row[form_img]">תמונת טופס</label>
                <input type="file" name="row[form_img]" id="task_form_img_file" class="form-input" data-msg-required="*" value="" />
				<?php if($form_img_url = $this->get_form_file_url('form_img')): ?>
					<div>

						<a href="<?= $form_img_url ?>" target="_BLANK">
							<img src='<?= $form_img_url ?>?cache=<?= rand() ?>'  style="max-width:200px;"/>
						</a>
						<br/>
						<a href="<?= current_url() ?>&remove_file=form_img">הסר</a>
					</div>
				<?php endif; ?>
				
				
			</div>	

		</div>
		<hr/>
		<div class="row-fluid">	
			<div class="form-group span3">
				<label id="submit_label"></label>
				<input type="submit"  class="submit-btn"  value="שליחה" />
			</div>

            <div class="form-group span3">
                <hr/>
				<a href="<?= inner_url('tasks/delete/') ?>?row_id=<?= $this->data['task_info']['id'] ?>"  class="delete-link" >מחיקה</a>
			</div>
		</div>
	</form>
</div>
<?php $this->register_script("js","tiny_mce",inner_url("vendor/tinymce/tinymce/tinymce.min.js"),"head"); ?>
<script type="text/javascript">

tinymce.init({
  selector: '#task_contend_textarea',
  plugins: 'advlist link image lists code',
 // toolbar: 'advlist link image lists',
  toolbar: 'undo redo | link image  code | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent',
  /* without images_upload_url set, Upload tab won't show up*/
  images_upload_url: 'postAcceptor.php',
  width: 600,
	height: 300,
	directionality: 'rtl',

});

  </script>		