jQuery(document).ready(function($){


 

    $('#blurb_insert').click(function(){

        // var paypal_mode = $('.paypal_mode').val();
        var paypal_mode = $('.paypal_mode').val();
        var paypal_item_name = $('.paypal_item_name').val();
        var paypal_price = $('.paypal_price').val();
        var paypal_email = $('.paypal_email').val();
        var paypal_currency = $('.paypal_currency').val();
        var paypal_submit_class = $('.paypal_submit_class').val();
        var paypal_submit_value = $('.paypal_submit_value').val();
        var paypal_return_url = $('.paypal_return_url').val();
        var paypal_custom = $('.paypal_custom').val();

        var paypal_object = {};
        paypal_object['mode'] = paypal_mode;
        paypal_object['name'] = paypal_item_name;
        paypal_object['price'] = paypal_price;
        paypal_object['email'] = paypal_email;
        paypal_object['currency'] = paypal_currency;
        paypal_object['submit_class'] = paypal_submit_class;
        paypal_object['submit_value'] = paypal_submit_value;
        paypal_object['return'] = paypal_return_url;
        paypal_object['custom'] = paypal_custom;

        $.each(paypal_object ,function(key, value) {
            if (value == null || value == '' || value == 'undefined') {
                delete paypal_object[key];
            }
        });


        var shortcode = '[PAYPAL_IPN_SHORTCODE ';
        var shortcode_atts = '';
        $.each(paypal_object, function(index, value) {
            shortcode_atts += index+"='"+value+"' ";
        });

        var shortcode = shortcode + shortcode_atts;
        var shortcode = shortcode +  ']';

        wp.media.editor.insert(shortcode);
        // $('#blurb-modal-content').trigger("reset");
        parent.$.fancybox.close();
    });


});