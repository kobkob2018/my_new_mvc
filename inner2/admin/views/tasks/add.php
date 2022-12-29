<h3>הוספת משימה</h3>
<p>
        <a href="<?= inner_url("tasks/all/") ?>">חזרה</a>
</p>
<hr/>
<div id="task_form_wrap" class="form-gen task-form">
    <?php $this->include_view('messages/formMessages.php'); ?>
	<form name="send_form" class="send-form form-validate" id="send_form" method="post" action="">
		<input type="hidden" name="sendAction" value="createSend" />
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
                <textarea name="row[description]" id="row_title" class="form-input" data-msg-required="*"><?= $this->get_form_input("description"); ?></textarea>
               
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

		</div>
		<hr/>
		<div class="row-fluid">	
			<div class="form-group span3">
				<label id="submit_label"></label>
				<input type="submit"  class="submit-btn"  value="שליחה" />
			</div>
		</div>
	</form>
</div>