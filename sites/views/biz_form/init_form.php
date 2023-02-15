
<div class="biz-form-generator">
    <div class="form-header">
        <h3 class='form-title'>
            <?= $info['biz_form']['title'] ?>
        </h3>
    </div>
    
    <form class="biz-form" action = "javascript://" method = "POST">
        <input type="hidden" name="submit_form" value="1" />
        <input class="cat-id-holder" type="hidden" name="biz[cat_id]" value="" />
        <div class="biz-form-placeholder"  data-form_id='<?= $info['biz_form']['id'] ?>' data-cat_id='<?= $info['biz_form']['cat_id'] ?>' data-fetch_url='<?= inner_url("biz_form/fetch/") ?>'>
            <span class = "append-spot"></span>
            <?php if(!isset($info['input_remove']['name'])): ?>
                <div class="form-group">
                    <input 
                    type="text" 
                    name="biz[full_name]" 
                    id="biz_phone" 
                    class="form-input validate" 
                    placeholder="שם מלא" 
                    required 
                    data-msg_required="נא להוסיף שם מלא" 
                    data-msg_invalid="נא להוסיף שם מלא תקין"
                    pattern="^(([A-Za-z_\-\u0590-\u05FF ])\2?(?!\2))+$" 
                    minlength="2"
                    />
                </div>
            <?php else: ?>
                <input type="hidden" name="biz[full_name]" value="no-name" />
            <?php endif; ?>
            <?php if(!isset($info['input_remove']['phone'])): ?>
                <div class="form-group">
                    <input type="text" name="biz[phone]" id="biz_phonne" 
                    required 
                    pattern="^(?=\d)(?=.{6,})(?!.*(\d)\1{4})((0[23489]{1}[5-9]{1})|(0[5]{1}[01234578]{1}[2-9]{1})|0[7]{1}[2-9]{1}[2-9]{1})?(\d{2}?\d{4})$" 
                    minlength="9" 
                    maxlength="10"  
                    class="form-input validate phoneNumber" 
                    placeholder="טלפון" 
                    required data-msg_required="יש למלא טלפון" data-msg_invalid="יש למלא טלפון תקין"
                     />
                </div>  
                
            <?php else: ?>
                <input type="hidden" name="biz[phone]" value="" />
            <?php endif; ?>
            <?php if(!isset($info['input_remove']['email'])): ?>
                <div class="form-group">
                    <input type="text" name="biz[email]" id="biz_phone" class="form-input validate" placeholder="אימייל" required data-msg_required="יש למלא אימייל" data-msg_invalid="יש למלא אימייל תקין" />
                </div>
            <?php else: ?>
                <input type="hidden" name="biz[email]" value="no-mail" />
            <?php endif; ?>
            <?php if(!isset($info['input_remove']['city'])): ?> 
                <div class="form-group">
                    <select name="biz[city]" id="biz_city" class="form-input validate" required data-msg_required="אנא בחר עיר">
                        <option value = "">בחר עיר</option>
                        <?php foreach($this->data['city_select']['options'] as $option): ?>
                            <option value = "<?= $option['id'] ?>" class="city-option deep-<?= $option['deep'] ?>"><?= $option['label'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>      
            <?php else: ?>
                <input type="hidden" name="biz[city]" value="0" />
            <?php endif; ?>                        
            <div class="loading-message hidden">
                <div class="loader-icon">
                
                </div>              
            </div>
        </div>
    </form>
    <div class="submit-wrap pending-state form-group">
        <input type="submit" class="submit-button form-input" data-status="pending" value="שליחה" />
    </div>
</div>

<?php $this->register_script('js','biz_form_js',styles_url('style/js/biz_form.js'),'foot'); ?> 