<?php

/**
 *
 * @link       www.visamultimedia.com
 * @since      1.0.0
 *
 * @package    Vvb
 * @subpackage Vvb/admin
 */


/**
 * The helper class for the public-facing functionality of the plugin.
 *
 * @package    Vvb
 * @subpackage Vvb/public
 * @author     Gabriele Coquillard <gabriele.coquillard@gmail.com>
 */
class Vvb_Admin_Options {

	/**
	 * Helper class
	 *
	 * @since    1.0.0
	 * @access   public
	 * @var      array    $options
	 */
	public $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		$this->options = get_option( 'vvb_options' );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_add_options_page() {
		add_options_page( 'Visa Vertical Booking', 'Visa Vertical Booking', 'manage_options', 'vvb', array( $this, 'vvb_options_page' ) );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_options_page() {
		include_once 'partials/vvb-admin-display.php';
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_init_options() {
		register_setting( 'vvb_options', 'vvb_options', array( $this, 'vvb_options_validate' ) );
		
		add_settings_section( 'vvb_main', __('Main Settings', 'vvb'), array( $this, 'vvb_main_section_text' ), 'vvb' );
		add_settings_field( 'vvb_stub', __('Stub', 'vvb'), array( $this, 'vvb_setting_stub'), 'vvb', 'vvb_main' );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	function vvb_main_section_text() {
		echo '<p>' . __('Theese are the general settings', 'vvb') . '</p>';
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_stub() {
		echo "<input type='text' id='vvb_stub' name='vvb_options[stub]' value='{$this->options['stub']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @param mixed $input
	 * @return mixed
	 */
	public function vvb_options_validate( $input ) {
		
		return $input;
	}
}
