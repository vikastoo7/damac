jQuery(document).ready(function(){

    /* Gravity form confirmation loaded use to add custom attachment download option */
    jQuery(document).on('gform_confirmation_loaded', function(event, formId){
        jQuery.ajax({
            type: "POST",
            url: WOTADFORM_ADMIN.ajaxurl,
            data: {
                'action': 'wot_ad_form_confirmation_redirection',
                'formId':formId,
            },
            dataType: "JSON",
            beforeSend: function beforeSend() {

            },
            success: function (data) {
                if(data) {
                    var jsonData = data;
                    if( jsonData.ad_option == "1" ) {
                        var link = document.createElement('a');
                        link.href = jsonData.url;
                        link.download = jsonData.filename;
                        link.dispatchEvent(new MouseEvent('click'));
                    }
                    else {
                        window.open(jsonData.url);
                    }
                }
            }
        });
    });
});