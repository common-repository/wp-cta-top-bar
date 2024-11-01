jQuery(document).ready(function($){
    var show_option = wpctatb_settings.show_option;
	var content = wpctatb_settings.content;
    var background_color = wpctatb_settings.background_color;
    var text_color = wpctatb_settings.text_color;
    var sticky = wpctatb_settings.sticky;
    var is_admin_bar = wpctatb_settings.is_admin_bar;
    var set_cookie = parseInt( wpctatb_settings.set_cookie );
    var is_admin_login = wpctatb_settings.admin_login;

    // Check if Top Bar is sticky
    if ( sticky == 'yes' ) {
        if (is_admin_bar === 'yes'){
            var fixed_result = 'position:fixed; z-index:9999999; width:100%; left:0px; top:0; margin-top:32px;';
        } else {
            var fixed_result = 'position:fixed; z-index:9999999; width:100%; left:0px; top:0;';
        }
    } else {
        var fixed_result = '';
    }

    // Show Top Bar
    if (show_option == 'yes') {
        if (sticky == 'yes'){
            jQuery('<div id="wpctatb_hidden"></div><div id="wpctatopbar" style="' + fixed_result + ' background:' + background_color + ';"><div id="wpctatb_content" style="color:' + text_color + ';">' + content + '</div><div id="wpctatb_close"><a href="javascript:void(0)" nofollow style="color:' + text_color + ';">x</a></div></div>').prependTo('body');
        } else {
            jQuery('<div id="wpctatopbar" style="position:relative;' + fixed_result + ' background:' + background_color + ';"><div id="wpctatb_content" style="color:' + text_color + ';">' + content + '</div><div id="wpctatb_close"><a href="javascript:void(0)" nofollow style="color:' + text_color + ';">x</a></div></div>').prependTo('body');
        }
    }

    if( is_admin_login === 'yes' ) {
        jQuery.removeCookie('wpctatopbar'); //remove cookie if wp user can manage_options
    }

    if ( !jQuery.cookie('wpctatopbar') ) {
        jQuery( '#wpctatb_hidden' ).height( 44 );
        jQuery( '#wpctatopbar' ).show();

        jQuery('#wpctatb_close a').on('click', function() {

            if( is_admin_login === 'no' ) {
                jQuery.cookie('wpctatopbar', true, { expires: set_cookie });
            }

            jQuery('#wpctatb_hidden').remove();
            jQuery('#wpctatopbar').remove();
        });
    }
});

