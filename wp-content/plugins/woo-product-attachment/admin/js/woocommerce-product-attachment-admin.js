var count=0;
function select2object(ajaxtype){
    return {
     minimumInputLength: 3,   
      ajax: {
        url: ajaxurl,
        dataType: 'json',
        data: function (params) {
          var query = {
            action: ajaxtype+'_ajax',
            search: params.term
          };

          // Query parameters will be ?search=[term]&page=[page]
          return query;
        }

      }
    };
}
jQuery(document).ready(function() {
    var i=0;
    fileupload();
    delete_media();
   jQuery('#wcpoa-ui-tbody tr:not(:last) .productlist').select2(select2object('product'));
    jQuery('#wcpoa-ui-tbody tr:not(:last) .catlist').select2(select2object('category'));
    jQuery('#wcpoa-ui-tbody tr:not(:last) .taglist').select2(select2object('tag'));
    customValidation();
    jQuery('body').on('click', '.wcpoa-button,.wcpoa-icon.-plus', function (e) {
        e.preventDefault();
        var trr= jQuery('.trr');
        jQuery('.wcpoa-not-found-bulk-attach').hide();
        jQuery('.wcpoa-add-bulk-attach').remove();
        createAttachment(trr);
        count++;
        i++;
    });
    jQuery('.wcpoa_att_download_btn').click(function(){
        var buttontype=jQuery(this).val();
        if(buttontype === 'wcpoa_att_btn'){
            jQuery('.wcpoa_att_icon_file_selected').addClass('hide');
        } else{
           jQuery('.wcpoa_att_icon_file_selected').removeClass('hide'); 
        }
    });
    jQuery('body').on('change','.is_condition_select',function(){
        if(jQuery(this).val() === 'yes'){
            jQuery(this).parent().parent().parent().find('.is_condition').removeClass('hide');
        } else{
            jQuery(this).parent().parent().parent().find('.is_condition').addClass('hide');
        }
    });
    jQuery('body').on('focus','.wcpoa-php-date-picker', function(){
        jQuery(this).datepicker({ dateFormat: 'yy/mm/dd', minDate : 0 });
    });
    jQuery('body').on('change','.enable_date_time',function(){
        var att=jQuery(this).parent().parent().parent();
        if(jQuery(this).val() === 'yes'){
            jQuery(att).find('.enable_time').hide();    
            jQuery(att).find('.enable_date').show();
        } else if(jQuery(this).val() === 'time_amount'){
            jQuery(att).find('.enable_time').show();    
            jQuery(att).find('.enable_date').hide();
        } else{
            jQuery(att).find('.enable_time').hide();    
            jQuery(att).find('.enable_date').hide();
        }
    });
    jQuery('body').on('change','.wcpoa_attach_type_list',function(){
        var att=jQuery(this).parent().parent().parent(); 
        var type=jQuery(this).val(); 
        jQuery(att).find('.file_upload,.external_ulr').hide();    
        jQuery(att).find('.'+type).show();
    });          
    jQuery('body').on('click','.attachment_action .-minus',function(){
        var element=jQuery(this).parent().parent().parent().parent().parent().parent();
        delete_row(element);
    });
    jQuery('body').on('click', '.attachment_name label', function(e){
        e.preventDefault();
        jQuery(this).parent().parent().parent().parent().toggleClass('-collapsed');
    });
    jQuery('body').on('click', '.edit_bulk_attach', function(e){
        e.preventDefault();
        jQuery(this).parent().parent().parent().parent().parent().parent().toggleClass('-collapsed');
    });

    jQuery( '.group-title,.wcpoa-icon.-collapse' ).hover(function() {
        jQuery( this ).find('.attachment_action').css('visibility', 'visible');
    },function(){
        jQuery( this ).find('.attachment_action').css('visibility', 'hidden');
    });

    /* description toggle */
    jQuery( '.wcpoa-description-tooltip-icon' ).click( function( e) {
        e.preventDefault();
        jQuery( this ).next( 'p.wcpoa-description' ).toggle();
    } );

    // script for plugin rating
    jQuery(document).on('click', '.dotstore-sidebar-section .content_box .et-star-rating label', function(e){
        e.stopImmediatePropagation();
        var rurl = jQuery('#et-review-url').val();
        window.open( rurl, '_blank' );
    });

    // script for sidebar toggle button
    var span_full = jQuery('.toggleSidebar .dashicons');
    var show_sidebar = localStorage.getItem('wcpoa-sidebar-display');
    if( ( null !== show_sidebar || undefined !== show_sidebar ) && ( 'hide' === show_sidebar ) ) {
        jQuery('.all-pad').addClass('hide-sidebar');
        span_full.removeClass('dashicons-arrow-right-alt2').addClass('dashicons-arrow-left-alt2');
    } else {
        jQuery('.all-pad').removeClass('hide-sidebar');
        span_full.removeClass('dashicons-arrow-left-alt2').addClass('dashicons-arrow-right-alt2');
    }

    jQuery(document).on( 'click', '.toggleSidebar', function(){
        jQuery('.all-pad').toggleClass('hide-sidebar');
        if( jQuery('.all-pad').hasClass('hide-sidebar') ){
            localStorage.setItem('wcpoa-sidebar-display', 'hide');
            span_full.removeClass('dashicons-arrow-right-alt2').addClass('dashicons-arrow-left-alt2');
            jQuery('.all-pad .wcpoa-section-right').css({'-webkit-transition': '.3s ease-in width', '-o-transition': '.3s ease-in width',  'transition': '.3s ease-in width'});
            jQuery('.all-pad .wcpoa-section-left').css({'-webkit-transition': '.3s ease-in width', '-o-transition': '.3s ease-in width',  'transition': '.3s ease-in width'});
            setTimeout(function() {
                jQuery('#dotsstoremain .dotstore_plugin_sidebar').css('display', 'none');
            }, 300);
        } else {
            localStorage.setItem('wcpoa-sidebar-display', 'show');
            span_full.removeClass('dashicons-arrow-left-alt2').addClass('dashicons-arrow-right-alt2');
            jQuery('.all-pad .wcpoa-section-right').css({'-webkit-transition': '.3s ease-out width', '-o-transition': '.3s ease-out width',  'transition': '.3s ease-out width'});
            jQuery('.all-pad .wcpoa-section-left').css({'-webkit-transition': '.3s ease-out width', '-o-transition': '.3s ease-out width',  'transition': '.3s ease-out width'});
            jQuery('#dotsstoremain .dotstore_plugin_sidebar').css('display', 'block');
        }
    });
    
});
function customValidation(){
    jQuery('#post').submit(function(e){
        var isValid = true;

        jQuery('input.wcpoa-attachment-name').each(function() {
            if(!jQuery(this).parent().parent().parent().parent().hasClass('hidden')){
                if(jQuery(this).val() === '' && jQuery(this).val().length < 1) {
                    jQuery(this).addClass('error');
                    isValid = false;
                } else {
                   jQuery(this).removeClass('error');
                }

            }
        });  
        jQuery('.wcpoa_attach_type_list').each(function(){
            if(!jQuery(this).parent().parent().parent().parent().hasClass('hidden')){
                if(jQuery(this).val() === 'file_upload'){
                     if(jQuery(this).parent().parent().parent().find('.wcpoa-file-uploader input').val() === ''){
                             isValid = false;
                             jQuery(this).parent().parent().parent().find('.wcpoa-file-uploader input').addClass('error');
                             jQuery(this).parent().parent().parent().find('.wcpoa-file-uploader .wcpoa-error-message').show();
                     } else {
                             jQuery(this).parent().parent().parent().find('.wcpoa-file-uploader .wcpoa-error-message').hide();                                jQuery().hide();
                     } 
                } else{
                    if(jQuery(this).parent().parent().parent().find('.wcpoa-attachment-url').val() === ''){
                             isValid = false;
                             jQuery(this).parent().parent().parent().find('.wcpoa-attachment-url').addClass('error');
                     } else {
                            jQuery(this).parent().parent().parent().find('.wcpoa-attachment-url').removeClass('error');
                     }     
                }
                
            }
        });

        jQuery('.enable_date_time').each(function(){
            if(!jQuery(this).parent().parent().parent().parent().hasClass('hidden')){
                if(jQuery(this).val() === 'yes'){
                     if(jQuery(this).parent().parent().parent().find('input.wcpoa-php-date-picker').val() === ''){
                             isValid = false;
                             jQuery(this).parent().parent().parent().find('input.wcpoa-php-date-picker').addClass('error');
                        }  else{
                             jQuery(this).parent().parent().parent().find('input.wcpoa-php-date-picker').removeClass('error');                              
                     } 
                } else if(jQuery(this).val() === 'time_amount'){
                    if(jQuery(this).parent().parent().parent().find('input.wcpoa-attachment-_time-amount').val() === ''){
                             isValid = false;
                             jQuery(this).parent().parent().parent().find('input.wcpoa-attachment-_time-amount').addClass('error');
                     }  else{
                            jQuery(this).parent().parent().parent().find('input.wcpoa-attachment-_time-amount').removeClass('error');
                     }     
                }
                
            }
        });

        if(!isValid) {
            e.preventDefault();
            alert(wcpoa_vars.validation_msg);
        }
    });
}

function makeid(length) {
   var result           = '';
   var characters       = 'abcdefghijklmnopqrstuvwxyz0123456789';
   var charactersLength = characters.length;
   for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
   }
   return result;
}

function createAttachment(element){
    var cln = element[0].cloneNode(true);
    // Append the cloned <li> element to <ul> with id="myList1"
    var tbody=document.getElementById('wcpoa-ui-tbody');
    tbody.appendChild(cln);
    var last_attachment_id=makeid(13);
    jQuery('#wcpoa-ui-tbody tr:nth-last-child(2)').find('.wcpoa_attachments_id').val(last_attachment_id);
    jQuery('#wcpoa-ui-tbody tr:nth-last-child(2)').removeClass('hidden');
    jQuery('#wcpoa-ui-tbody tr:nth-last-child(2)').removeClass('trr');
    jQuery('#wcpoa-ui-tbody tr:nth-last-child(2)').attr('id',last_attachment_id);
    jQuery('#wcpoa-ui-tbody tr:nth-last-child(2)').attr('data-id',last_attachment_id);
    jQuery('#wcpoa-ui-tbody tr:nth-last-child(2) .misha_upload_image_button').attr('data-id',last_attachment_id);
    jQuery('#wcpoa-ui-tbody tr:nth-last-child(2) .misha_upload_image_button').attr('data-id',last_attachment_id);
    jQuery('#wcpoa-ui-tbody tr:nth-last-child(2) .wcpoa-icon.-pencil').attr('data-id',last_attachment_id);
    jQuery('#wcpoa-ui-tbody tr:nth-last-child(2) .wcpoa-icon.-cancel').attr('data-id',last_attachment_id);
    jQuery('#wcpoa-ui-tbody tr:nth-last-child(2) .productlist').attr('name','wcpoa_product_list['+last_attachment_id+'][]').select2(select2object('product'));
    jQuery('#wcpoa-ui-tbody tr:nth-last-child(2) .catlist').attr('name','wcpoa_category_list['+last_attachment_id+'][]').select2(select2object('category'));
    jQuery('#wcpoa-ui-tbody tr:nth-last-child(2) .taglist').attr('name','wcpoa_tag_list['+last_attachment_id+'][]').select2(select2object('tag'));
    jQuery('#wcpoa-ui-tbody tr:nth-last-child(2) .wcpoa_product_variation input').attr('name','wcpoa_variation['+last_attachment_id+'][]');
    jQuery('#wcpoa-ui-tbody tr:nth-last-child(2) .wcpoa-order-checkbox-list input').attr('name','wcpoa_order_status['+last_attachment_id+'][]');

    var lasttr = jQuery('#wcpoa-ui-tbody tr:nth-last-child(3) .order span').get(0);
    if(lasttr !== undefined){
        var index = parseInt(lasttr.innerHTML)+1;
        var ono = jQuery('#wcpoa-ui-tbody tr:nth-last-child(2) .order span').get(0);
        ono.innerHTML = '';
        setText(ono,index);
        var ono_new = jQuery('#wcpoa-ui-tbody tr:nth-last-child(2) .group-title .order .attchment_order').get(0);
        if(ono_new !== undefined){
            ono_new.innerHTML = '';
            setText(ono_new,index);                
        }
    }
    customValidation();
    return;      
}

function setText(element,text){
    var text_node = document.createTextNode(text);
    element.appendChild(text_node);        
}
function delete_row(element){
    var con = confirm('Are you sure you want to delete.');
    if(con){
        element.remove();
    }
}
function delete_media(){
    jQuery('body').on('click', '.wcpoa-icon.-cancel', function(e){
        e.preventDefault();
        element = jQuery('#'+jQuery(this).attr('data-id'));
        var con = confirm('Are you sure you want to delete.');
        if(con){
            element.find('.wcpoa-file-uploader input').val('');
            element.find('.wcpoa-file-uploader').removeClass('has-value');

        }
    });
}

function fileupload(){
    jQuery('body').on('click', '.misha_upload_image_button, .file-info .wcpoa-icon.-pencil', function(e){
        e.preventDefault();
            var attachment_div=jQuery('#'+jQuery(this).attr('data-id')).find('.wcpoa-file-uploader');
            
            var custom_uploader = wp.media({
                title: 'Insert file',
                button: {
                    text: 'Use this file' // button label text
                },
                multiple: false
            }).on('select', function() { // it also has "open" and "close" events 
                jQuery(attachment_div).addClass('has-value');
                var attachment = custom_uploader.state().get('selection').first().toJSON();
                jQuery(attachment_div).find('.wcpoa-error-message input').val(attachment.id);
                jQuery(attachment_div).find('.file-info p:nth-child(1) strong').text(attachment.title);
                jQuery(attachment_div).find('.file-info a').text(attachment.filename);
                jQuery(attachment_div).find('.file-info span').text(attachment.size);
            })
            .open();
    });
    jQuery('body').on('click', '.misha_remove_image_button', function(){
        jQuery(this).hide().prev().val('').prev().addClass('button').html('Upload file');
        return false;
    });
}