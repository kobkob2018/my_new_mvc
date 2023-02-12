
    <div class="biz-form-generator">
        <form class="biz-form" action = "javascript://" method = "POST">
            <div class="biz-form-placeholder"  data-form_id='<?= $info['biz_form']['id'] ?>' data-cat_id='<?= $info['biz_form']['cat_id'] ?>' data-fetch_url='<?= inner_url("biz_forms/fetch/") ?>'>
                <span class = "append-spot"></span>
                <div class="form-group">
                    <input type="text" name="biz[full_name]" id="biz_phone" class="form-input required" placeholder="שם מלא" data-msg-required="אנא הוסף שם מלא" aria-required="true" />
			    </div>
                <div class="form-group">
                    <input type="text" name="biz[phone]" id="biz_full_name" class="form-input phoneNumber required" placeholder="טלפון" data-msg-required="אנא הוסף מספר טלפון" data-msg-phonenumber="אנא הכנס מספר טלפון תקין." aria-required="true" />
			    </div>   
                <div class="form-group">
                    <select name="biz[city]" id="biz_city" class="form-input required" data-msg-required="אנא בחר עיר" aria-required="true">
                        <option value = "">בחר עיר</option>
                        <?php foreach($this->data['city_select']['options'] as $option): ?>
                            <option value = "<?= $option['id'] ?>" class="city-option deep-<?= $option['deep'] ?>"><?= $option['label'] ?></option>
                        <?php endforeach; ?>
                    </select>
			    </div>                              
                <div class="loading-message hidden">loading....</div>
            </div>
        </form>
        <div class="submit-wrap pending-state">
            <input type="submit" class="submit-button" data-status="pending" value="שליחה" />
        </div>
    </div>

<?php $this->register_script('js','biz_form_js',styles_url('style/js/biz_form.js'),'foot'); ?> 
<div class="bizform-apitoui" style="display:none;"> 

</div>
