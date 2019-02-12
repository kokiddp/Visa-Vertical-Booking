<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.elk-lab.com
 * @since      1.0.0
 *
 * @package    Vvb
 * @subpackage Vvb/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Vvb
 * @subpackage Vvb/public
 * @author     Gabriele Coquillard <gabriele@visamultimedia.com>
 */
class Vvb_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $environment    The environment state of the plugin.
	 */
	private $environment;

	/**
	 * Shortcodes class
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      Vvb_Public_Shortcodes		$shortcodes		Shortcodes class instance.
	 */
	private $shortcodes;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $environment ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->environment = $environment;

		$this::add_dependencies();

		$this->shortcodes = new Vvb_Public_Shortcodes();

		$this->options = get_option( 'vvb_options' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vvb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vvb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( $this->environment == 'production' ) {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vvb-public.min.css', array(), $this->version, 'all' );
		}
		else {
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/vvb-public.css', array(), time(), 'all' );
		}

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Vvb_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Vvb_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		if ( $this->environment == 'production' ) {
			wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vvb-public.min.js', array( 'jquery' ), $this->version, false );
		}
		else {
			wp_register_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/vvb-public.js', array( 'jquery' ), time(), false );
		}

		$option_array = array(
			'url' => $this->options['url'],
			'id_albergo' => $this->options['id_albergo'],
			'id_stile' => $this->options['id_stile'],
			'dc' => $this->options['dc'],
			'minNights' => $this->options['min_nights'],
			'maxRooms' => $this->options['max_rooms'],
			'maxPeople' => $this->options['max_people'],
			'defaultAdults' => $this->options['default_adults'],
			'minAdultsFirstRoom' => $this->options['min_adults_first_room'],
			'minAdultsOtherRooms' => $this->options['min_adults_other_rooms'],
			'minAgeChildren' => $this->options['min_age_children'],
			'maxAgeChildren' => $this->options['max_age_children'],
		);
		wp_localize_script( $this->plugin_name, 'vvb_options', $option_array );

		wp_enqueue_script( $this->plugin_name );

	}

	/**
	 * Load the dependencies for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function add_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-vvb-public-shortcodes.php';

	}

}
