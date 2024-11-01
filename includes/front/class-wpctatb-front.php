<?php
/**
 * WooCommerce Admin
 *
 * @class    WPCTATB_Front
 * @author   Alipio Gabriel
 * @category Admin
 * @version  0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WC_Front class.
 */
class WPCTATB_Front {

	private $options;
	private $show_option;
	private $content;
	private $background_color;
	private $text_color;
	private $position;
	private $wpctatb_settings;
	private $cookie_setting;
	private $admin_login;

	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'front_styles' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'front_scripts' ) );
	}

	public function front_styles() {
		wp_enqueue_style( 'wpctatb-front-style', plugins_url('includes/css/wpctatb-style.css', WPCTATB_FILE ) );
	}

	public function front_scripts() {
		wp_enqueue_script( 'jquery-cookie', plugins_url('includes/js/jquery.cookie.js', WPCTATB_FILE ), array('jquery'), false, false );
		wp_enqueue_script( 'wpctatb-front-script', plugins_url('includes/js/wpctatb-front-script.js', WPCTATB_FILE ), array(), false, true );
		
		// getting the options
		$this->options = get_option('wpctatb_option');

		if ( is_admin_bar_showing() ) {
        	$wpctatb_is_admin_bar = 'yes';
	    } else {
	        $wpctatb_is_admin_bar = 'no';
	    }

	    $this->show_option = ! empty( $this->options[ 'show_option' ] ) ? $this->options[ 'show_option' ] : "no";
	    $this->content = do_shortcode( $this->options[ 'wpctatb_TinyMCE_content' ]  );
	    $this->background_color = $this->options[ 'background_color' ];
	    $this->text_color = $this->options[ 'text_color' ];
	    $this->position = $this->options[ 'option_stick' ];
	    $this->cookie_setting = ! empty( $this->options[ 'cookie_setting' ] ) ? $this->options[ 'cookie_setting' ] : 7;
	    $this->admin_login = ( current_user_can( 'manage_options' ) ? 'yes' : 'no' );

		$this->wpctatb_settings = array(
			'show_option' => $this->show_option,
	        'content' => $this->content,
	        'background_color' => $this->background_color,
	        'text_color' => $this->text_color,
	        'sticky' => $this->position,
	        'is_admin_bar' => $wpctatb_is_admin_bar,
	        'set_cookie' => $this->cookie_setting,
	        'admin_login' => $this->admin_login,
	    );

		$settings = $this->wpctatb_settings;
		// sending the options to the js file
	    wp_localize_script( 
	    	'wpctatb-front-script', 
	    	'wpctatb_settings', 
	    	$settings
	    );
	}
}

return new WPCTATB_Front();