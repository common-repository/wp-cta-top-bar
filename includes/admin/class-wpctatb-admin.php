<?php
/**
 * WooCommerce Admin
 *
 * @class    WPCTATB_Admin
 * @author   Alipio Gabriel
 * @category Admin
 * @version  0.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WC_Admin class.
 */
class WPCTATB_Admin {

	private $options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_wpctatb_page' ) );
		add_action( 'admin_init', array( $this, 'init' ) );
	}

	/**
    * Add options page
    */
    public function add_wpctatb_page() {
        // This page will be under "Settings"
        add_menu_page( 
			__( 'Top Bar Setting', 'wpctatb' ), //Page title
			__( 'WP CTA Top Bar', 'wpctatb' ), //Admin menu title
			'manage_options', // If user can manage options
			'wpctatb-admin-setting', // Plugin permalink 
			array( $this, 'dashboard_page_html') 
		);
    }

	public function init() {
		register_setting(
            'wpctatb_option_group', // Option group
            'wpctatb_option'
        );

        add_settings_section(
            'wpctatb_admin_setting_section', // ID
            __( 'WP CTA Top Bar Setting', 'wpctatb' ), // Title
            array( $this, 'print_section_info' ), // Callback
            'wpctatb-admin-setting' // Page
        );  

        add_settings_field(
            'wpctatb_show_option', // ID
            __( 'Show Top Bar?', 'wpctatb' ), // Title
            array( $this, 'show_option_callback' ), // Callback
            'wpctatb-admin-setting', // Page
            'wpctatb_admin_setting_section' // Section           
        );  

        add_settings_field(
            'wpctatb_content', // ID
            __( 'Content', 'wpctatb' ), // Title
            array( $this, 'text_editor_callback' ), // Callback
            'wpctatb-admin-setting', // Page
            'wpctatb_admin_setting_section' // Section           
        );   

        add_settings_field(
        	'wpctatb_background_color', // ID
            __( 'Select background color', 'wpctatb' ), // Title
            array( $this, 'background_color_callback' ), // Callback
            'wpctatb-admin-setting', // Page
            'wpctatb_admin_setting_section' // Section           
        );     

        add_settings_field(
            'wpctatb_text_color', // ID
            __( 'Select text color', 'wpctatb' ), // Title
            array( $this, 'text_color_callback' ), // Callback
            'wpctatb-admin-setting', // Page
            'wpctatb_admin_setting_section' // Section           
        );  

        add_settings_field(
        	'wpctatb_position_setting', // ID
            __('Make top bar sticky?', 'wpctatb'), // Title
            array( $this, 'position_setting_callback' ), // Callback
            'wpctatb-admin-setting', // Page
            'wpctatb_admin_setting_section' // Section           
        );

        add_settings_field(
            'wpctatb_cookie_setting', // ID
            __('Set day before top bar show up when top bar is closed', 'wpctatb'), // Title
            array( $this, 'cookie_setting_callback' ), // Callback
            'wpctatb-admin-setting', // Page
            'wpctatb_admin_setting_section' // Section           
        );    
	}


     /** 
     * Plugin Admin Dashboard
     */
	public function dashboard_page_html() {
		$this->options = get_option( 'wpctatb_option' );
		?>
		<div class="card wpctatb-dashboard">
	    	<form method="POST" action="<?php echo esc_url('options.php'); ?>">
	    		<?php 
		    		// This prints out all hidden setting fields
	                settings_fields( 'wpctatb_option_group' );
	                do_settings_sections( 'wpctatb-admin-setting' );
	                submit_button();
	    		?>
	      	</form>
		</div>
		<?php
	}


     /** 
     * Print the Section text
     */
    public function print_section_info() {
        esc_html_e( '' );
    }

    /** 
    * Print Stay on top option
    */
    public function show_option_callback() {
        $field_name = "show_option";

        if ( ! empty( $this->options[$field_name] ) ) {
            if ( "yes" == $this->options[$field_name] ) {
                $yes_status = "checked";
                $no_status = "";
            } else {
                $no_status = "checked";
                $yes_status = "";
            }
        }else{
            $yes_status = "checked";
            $no_status = "";
        }

        printf(
            '<input type="radio" name="wpctatb_option[%1$s]" value="yes" %4$s>%2$s <br>
            <input type="radio" name="wpctatb_option[%1$s]" value="no" %5$s>%3$s <br>',
            esc_attr__( $field_name, 'wpctatb' ),
            esc_html__( 'Yes', 'wpctatb' ),
            esc_html__('No', 'wpctatb'),
            $yes_status,
            $no_status

        );
    }

    /** 
     * Print WP Visual editor
     */
    public function text_editor_callback() {
    	$field_name = "wpctatb_TinyMCE_content";

    	if ( ! empty( $this->options[$field_name] ) ) {
    		$content = $this->options[$field_name];
    	}else{
    		$content = Null;
    	}

        printf(
            '<div id="post-body-content">%s</div>',
            wp_editor( $content, $field_name, $settings = array(
            	'textarea_name' => 'wpctatb_option['.$field_name.']'
            ) )
       	);
    }

    /** 
     * Print Color picker field
     */
    public function background_color_callback() {
    	$field_name = "background_color";

    	if ( ! empty( $this->options[$field_name] ) ) {
    		$value = esc_attr( $this->options[$field_name] );
    	} else {
    		$value = esc_attr( '#000000' ); //color black as default background color
    	}

        printf(
            '<input type="text" value="%s" class="background-color-field" name="wpctatb_option[%s]"/>',
            $value,
            $field_name
        );
    }

    /** 
     * Print Text Color picker field
     */
    public function text_color_callback() {
        $field_name = "text_color";

        if ( ! empty( $this->options[$field_name] ) ) {
            $value = esc_attr( $this->options[$field_name] );
        } else {
            $value = esc_attr( '#ffffff' ); //color white as default text color
        }

        printf(
            '<input type="text" value="%s" class="text-color-field" name="wpctatb_option[%s]"/>',
            $value,
            $field_name
        );
    }    

    /** 
    * Print Stay on top option
    */
    public function position_setting_callback() {
        $field_name = "option_stick";

        if ( ! empty( $this->options[$field_name] ) ) {
            if ( "yes" == $this->options[$field_name] ) {
                $yes_status = "checked";
                $no_status = "";
            } else {
                $no_status = "checked";
                $yes_status = "";
            }
        }else{
            $no_status = "checked";
            $yes_status = "";
        }

        printf(
            '<input type="radio" name="wpctatb_option[%1$s]" value="yes" %4$s>%2$s <br>
  			<input type="radio" name="wpctatb_option[%1$s]" value="no" %5$s>%3$s <br>',
            esc_attr__( $field_name, 'wpctatb' ),
            esc_html__( 'Yes', 'wpctatb' ),
            esc_html__('No', 'wpctatb'),
            $yes_status,
            $no_status

        );
    }

    /** 
     * Print Cookie Setting
     */
    public function cookie_setting_callback() {
        $field_name = "cookie_setting";

        if ( ! empty( $this->options[$field_name] ) ) {
            $value = esc_attr( $this->options[$field_name] );
        } else {
            $value = esc_attr( '7' ); //color white as default text color
        }

        printf(
            '<input type="number" value="%d" class="cookie-setting" name="wpctatb_option[%s]" min="7" max="30"/>',
            intval( $value ),
            $field_name
        );
    }  

}

if( is_admin() )
return new WPCTATB_Admin();
