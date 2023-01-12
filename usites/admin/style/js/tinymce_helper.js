Tiny_mce_callback_handler_class = function(){
    this.init = function(callback, value, meta){
        this.meta = meta;
        this.callback = callback;
        this.value = value;
        window.open(global_media_library_url,'media_library_window','popup');
    }

    this.call_callbeck = function(filename, payload){
        this.callback(filename, payload);
    }
}

function update_from_media_library(file_name){
    tiny_mce_callback_handler.call_callbeck(file_name);
}

function init_tinymce(selector_identifier,media_uploader_url, media_library_url){
    global_media_library_url = media_library_url;
    tinymce.init({
        selector: selector_identifier,
        plugins: 'image code textcolor link colorpicker lists codesample advlist autosave contextmenu emoticons fullscreen help hr insertdatetime nonbreaking paste preview' ,
        toolbar: 'undo redo | image code link | numlist bullist| forecolor backcolor | paste preview |nonbreaking codesample restoredraft emoticons | fullscreen help hr insertdatetime',
        contextmenu: "link image inserttable | cell row column deletetable",
        directionality : "rtl",
        insertdatetime_dateformat: "%Y-%m-%d",
        /* without images_upload_url set, Upload tab won't show up*/
        images_upload_url: media_uploader_url,
        content_style: 'img {max-width: 100%; height:auto;}',
    
        file_picker_callback: function(callback, value, meta) {
            return tiny_mce_callback_handler.init(callback, value, meta);
        }
        
    });

}

tiny_mce_callback_handler = new Tiny_mce_callback_handler_class();
global_media_library_url = null;