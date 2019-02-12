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
		add_options_page( __('Visa Vertical Booking', 'visa-vertical-booking'), __('Visa Vertical Booking', 'visa-vertical-booking'), 'manage_options', 'vvb', array( $this, 'vvb_options_page' ) );
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
		
		add_settings_section( 'vvb_main', __('Main Settings', 'visa-vertical-booking'), array( $this, 'vvb_main_section_text' ), 'vvb' );
		add_settings_field( 'vvb_url', __('URL base', 'visa-vertical-booking'), array( $this, 'vvb_setting_url'), 'vvb', 'vvb_main' );
		add_settings_field( 'vvb_id_albergo', __('ID Albergo', 'visa-vertical-booking'), array( $this, 'vvb_setting_id_albergo'), 'vvb', 'vvb_main' );
		add_settings_field( 'vvb_id_stile', __('ID Stile', 'visa-vertical-booking'), array( $this, 'vvb_setting_id_stile'), 'vvb', 'vvb_main' );
		add_settings_field( 'vvb_dc', __('DC', 'visa-vertical-booking'), array( $this, 'vvb_setting_dc'), 'vvb', 'vvb_main' );

		add_settings_section( 'vvb_config', __('Configuration Settings', 'visa-vertical-booking'), array( $this, 'vvb_config_section_text' ), 'vvb' );
		add_settings_field( 'vvb_min_nights', __('Minimum nights stay', 'visa-vertical-booking'), array( $this, 'vvb_setting_min_nights'), 'vvb', 'vvb_config' );
		add_settings_field( 'vvb_max_rooms', __('Maximum bookable rooms', 'visa-vertical-booking'), array( $this, 'vvb_setting_max_rooms'), 'vvb', 'vvb_config' );
		add_settings_field( 'vvb_max_people', __('Maximum people per room', 'visa-vertical-booking'), array( $this, 'vvb_setting_max_people'), 'vvb', 'vvb_config' );
		add_settings_field( 'vvb_default_adults', __('Default adults per room', 'visa-vertical-booking'), array( $this, 'vvb_setting_default_adults'), 'vvb', 'vvb_config' );
		add_settings_field( 'vvb_min_adults_first_room', __('Minimum adults in first room', 'visa-vertical-booking'), array( $this, 'vvb_setting_min_adults_first_room'), 'vvb', 'vvb_config' );
		add_settings_field( 'vvb_min_adults_other_rooms', __('Minimum adults in other rooms', 'visa-vertical-booking'), array( $this, 'vvb_setting_min_adults_other_rooms'), 'vvb', 'vvb_config' );
		add_settings_field( 'vvb_max_age_children', __('Maximum age for children', 'visa-vertical-booking'), array( $this, 'vvb_setting_max_age_children'), 'vvb', 'vvb_config' );
		add_settings_field( 'vvb_min_age_children', __('Minimum age for children', 'visa-vertical-booking'), array( $this, 'vvb_setting_min_age_children'), 'vvb', 'vvb_config' );
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	function vvb_main_section_text() {
		echo '<p>' . __('Theese are the general settings', 'visa-vertical-booking') . '</p>';
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_setting_url() {
		echo "<input type='text' style='width:100%' id='vvb_url' name='vvb_options[url]' value='{$this->options['url']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_setting_id_albergo() {
		echo "<input type='text' id='vvb_id_albergo' name='vvb_options[id_albergo]' value='{$this->options['id_albergo']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_setting_id_stile() {
		echo "<input type='text' id='vvb_id_stile' name='vvb_options[id_stile]' value='{$this->options['id_stile']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_setting_dc() {
		echo "<input type='text' id='vvb_dc' name='vvb_options[dc]' value='{$this->options['dc']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	function vvb_config_section_text() {
		echo '<p>' . __('Theese are the configuration settings', 'visa-vertical-booking') . '</p>';
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_setting_min_nights() {
		echo "<input type='number' step='1' min='1' id='vvb_min_nights' name='vvb_options[min_nights]' value='{$this->options['min_nights']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_setting_max_rooms() {
		echo "<input type='number' step='1' min='1' id='vvb_max_rooms' name='vvb_options[max_rooms]' value='{$this->options['max_rooms']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_setting_max_people() {
		echo "<input type='number' step='1' min='1' id='vvb_max_people' name='vvb_options[max_people]' value='{$this->options['max_people']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_setting_default_adults() {
		echo "<input type='number' step='1' min='1' id='vvb_default_adults' name='vvb_options[default_adults]' value='{$this->options['default_adults']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_setting_min_adults_first_room() {
		echo "<input type='number' step='1' min='1' id='vvb_min_adults_first_room' name='vvb_options[min_adults_first_room]' value='{$this->options['min_adults_first_room']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_setting_min_adults_other_rooms() {
		echo "<input type='number' step='1' min='1' id='vvb_min_adults_other_rooms' name='vvb_options[min_adults_other_rooms]' value='{$this->options['min_adults_other_rooms']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_setting_max_age_children() {
		echo "<input type='number' step='1' min='1' max='17' id='vvb_max_age_children' name='vvb_options[max_age_children]' value='{$this->options['max_age_children']}' />";
	}

	/**
	 * Undocumented function
	 *
	 * @return void
	 */
	public function vvb_setting_min_age_children() {
		echo "<input type='number' step='1' min='0' max='16' id='vvb_min_age_children' name='vvb_options[min_age_children]' value='{$this->options['min_age_children']}' />";
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
