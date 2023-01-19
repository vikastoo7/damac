var ocount = 1;
jQuery(function ($) {

   $('body').on( 'click', '.wot_attachment_name', function(e){

           e.preventDefault();

           var button = $(this),
               custom_uploader = wp.media({
                   title: 'Insert File',
                   library : {
                       // uploadedTo : wp.media.view.settings.post.id, // attach to the current post?
                       /* type : 'image'*/
                   },
                   button: {
                       text: 'Use this file' // button label text
                   },
                   multiple: false
               }).on('select', function() { // it also has "open" and "close" events
                   var attachment = custom_uploader.state().get('selection').first().toJSON();

                   button.html(attachment.filename);
                   button.attr('href',attachment.url).next().show().next().val(attachment.id);

                   if(button.parent().hasClass('file-attachment-section')) {
                       button.parent().parent().parent().parent().parent().find('.file_validtion').hide();
                   }
               }).open();
       });

    // on remove button click
    $('body').on('click', '.remove-attachment', function(e){

        e.preventDefault();

        var button = $(this);
        button.next().val(''); // emptying the hidden field
        button.hide().prev().attr('href','javascript:void(0)');
        button.hide().prev().html('<i class="dashicons-before dashicons-upload"></i>');

    });

});
function checkValidation () {
   var attach_files = jQuery('.add-more-section .wot-ea-form-table-add .wot_attachment_file_default');
   var validate = true;
   if(attach_files) {
       attach_files.each(function () {
           var wot_attachment_file_default = jQuery(this).val();
           if(wot_attachment_file_default == '') {
               console.log(jQuery(this).parent().parent().parent().parent().parent().html());
               jQuery(this).parent().parent().parent().parent().parent().find('.file_validtion').show();
               validate = false;
           }
       });
   }
    if(validate) {

        return true;
    }
    else {

        return false;
    }



}