<?php 
/**
 * Main Plugin setup
 *
 * @author   Alipio
 * @package  AG Play Ground
 * @since    0.1
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WPCTATopBar {
	/**
	* Plugin Version
	*
	* @var string
	*/
	public $version = '0.4.1';
	
	protected static $_instance = null;

	/**
	* Main Plugin Instance.
	*
	* Ensures only one instance of Plugin is loaded or can be loaded.
	*
	* @since 0.1
	* @static
	* @return Plugin - Main instance.
	*/
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

	/**
	* Plugin Constructor.
	* @since 0.1
	*/
	public function __construct() {
		$this->define_constants();
		$this->includes();
		$this->init_hooks();
		$this->admin_assets();
	}

	/**
	 * Hook into actions and filters.
	 *
	 * @since 0.1
	 */
	private function init_hooks() {
		register_activation_hook( WPCTATB_FILE, array( $this,'plugin_activate' ) ); //activate hook
    	register_deactivation_hook( WPCTATB_FILE, array( $this,'plugin_deactivate' ) ); //deactivation hook
    	register_uninstall_hook( WPCTATB_FILE, array( $this,'plugin_uninstall' ) ); //uninstall hook
	}

	private function admin_assets() {
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
	}

	public function admin_styles() {
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_style( 'wpctatb-style', plugins_url('includes/css/wpctatb-admin-style.css', WPCTATB_FILE ) );
	}

	public function admin_scripts() {
		wp_enqueue_script( 'admin-script', plugins_url('includes/js/wpctatb-admin-script.js', WPCTATB_FILE ), array( 'wp-color-picker' ), false, true );
	}


	/**
	 * Define Plugin Constants.
	 */
	private function define_constants() {
		$upload_dir = wp_upload_dir( null, false );

		$this->define( 'WPCTATB_ABSPATH', dirname( WPCTATB_FILE ) . '/' );
		$this->define( 'WPCTATB_BASENAME', plugin_basename( WPCTATB_FILE ) );
		$this->define( 'WPCTATB_VERSION', $this->version );
	}

	/**
	 * Include required core files used in admin and on the frontend.
	 */
	public function includes() {
		include_once( WPCTATB_ABSPATH . 'includes/admin/class-wpctatb-admin.php' );
		include_once( WPCTATB_ABSPATH . 'includes/front/class-wpctatb-front.php' );
	}

	/**
	 * Define constant if not already set.
	 *
	 * @param string      $name  Constant name.
	 * @param string|bool $value Constant value.
	 */
	private function define( $name, $value ) {
		if ( ! defined( $name ) ) {
			define( $name, $value );
		}
	}

	/**
	 * Plugin activate function
	 *
	 * @since 0.1
	 */
	public function plugin_activate() {
		$wpctatb_options = get_option('wpctatb_option', null);

		if ( $wpctatb_options['show_option']  === null ) {
			$wpctatb_default = array(
	        	'show_option' => 'yes',
	        	'wpctatb_TinyMCE_content' => __( 'Your call to action message', 'wpctatb' ),
	        	'background_color' => '#000000',
	        	'text_color' => '#ffffff',
	        	'option_stick' => 'no',
	        	'cookie_setting' => 7,
	    	);
	    	update_option( 'wpctatb_option', $wpctatb_default );
		}
	}

	/**
	 * Plugin deactivate function
	 *
	 * @since 0.1
	 */
	public function plugin_deactivate() {
		
	}

	/**
	 * Plugin uninstall function
	 *
	 * @since 0.1
	 */
	public function plugin_uninstall() {
		delete_option( 'wpctatb_option' );
	}
}	

?>