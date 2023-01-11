<div class = "form-wrap">

    <?php $this->include_view('messages/formMessages.php'); ?>
    <form name="send_form" class="send-form form-validate" id="send_form" method="post" action="" <?= $this->data['form_builder']['enctype_str'] ?>>
    <input type="hidden" name="sendAction" value="<?= $this->data['form_builder']['sendAction'] ?>" />
    
    <?php if(isset($this->data['form_builder']['row_id'])): ?>
        <input type="hidden" name="row_id" value="<?= $this->data['form_builder']['row_id'] ?>" />
        <?php endif; ?>

            
        <?php foreach($this->data['form_builder']['fields_collection'] as $field_key=>$build_field): ?>

            <div class='form-group <?= isset($build_field['css_class'])? $build_field['css_class']: "" ?>'>

                <label for='row[<?= $field_key ?>]'><?= $build_field['label'] ?></label>
                <?php if($build_field['type'] == 'text'): ?>
                <div class='form-group span3'>
                    
                    <input type='text' name='row[<?= $field_key ?>]" id="row_<?= $field_key ?>' class='form-input <?= $build_field['validate_frontend'] ?>' data-msg-required='*' value='<?= $this->get_form_input($field_key); ?>'  />
                    
                </div>	
                <?php endif; ?>
                    
                <?php if($build_field['type'] == 'select'): ?>
                    <div class='form-group span3'>
                        
                        <select  id='row_<?= $field_key ?>' name='row[<?= $field_key ?>]' class='form-select <?= $build_field['validate_frontend'] ?>' data-msg='יש לבחור <?= $build_field['label'] ?>'>
                            <?php foreach($this->get_select_options($field_key) as $option): ?>
                                <option value="<?= $option['value'] ?>" <?= $option['selected'] ?>><?= $option['title'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>	
                        <?php endif; ?>
                        
                        <?php if($build_field['type'] == 'textbox'): ?>
                            <div class="form-group span3">
                                
                                <textarea name="row[<?= $field_key ?>]" id="row_<?= $field_key ?>_textarea" class="form-input form-textarea" data-msg-required="*"><?= $this->get_form_input($field_key); ?></textarea>
                                <?php if(isset($build_field['reachtext']) && $build_field['reachtext']): ?>
<?php $this->register_script('js','tinymce',global_url('vendor/tinymce/tinymce/tinymce.min.js')); ?>
<script type="text/javascript">
    tinymce.init({
  selector: 'textarea#row_<?= $field_key ?>_textarea',
  plugins: 'image code',
  toolbar: 'undo redo | image code',

  /* without images_upload_url set, Upload tab won't show up*/
  images_upload_url: '<?= inner_url('media/upload/') ?>'
});
</script>
                                <?php endif; ?>
                            </div>	
                <?php endif; ?>
            
                <?php if($build_field['type'] == 'file'): ?>
                    <div class="form-group span3">
                        
                        <input type="file" name="row[<?= $field_key ?>]" id="row_<?= $field_key ?>" class="form-input" value="" />
                        <?php if($file_url = $this->get_form_file_url($field_key)): ?>
                        <div>
                            
                            <a href="<?= $file_url ?>" target="_BLANK">
                                <?php if($build_field['file_type'] == 'img'): ?>
                                    <img src='<?= $file_url ?>?cache=<?= rand() ?>'  style="max-width:200px;"/>
                                    <?php else: ?>
                                        צפה בקובץ
                                <?php endif; ?>
                            </a>
                            <br/>
                            <a href="<?= current_url() ?>&remove_file=<?= $field_key ?>">הסר <?= $build_field['label'] ?></a>
                        </div>
                        <?php endif; ?>
                    </div>	
                <?php endif; ?>
            </div>
            
        <?php endforeach; ?>
        <div class="form-group span3">
            <label id="submit_label"></label>
            <input type="submit"  class="submit-btn"  value="שליחה" />
        </div>
        <?php if(isset($this->data['form_builder']['row_id'])): ?>
            <div class="form-group span3">
                <hr/>
                <a href="<?= inner_url('pages/delete/') ?>?row_id=<?= $this->data['item_info']['id'] ?>"  class="delete-link" >מחיקה</a>
            </div>
        <?php endif; ?>
        
        
    
    </form>

</div>