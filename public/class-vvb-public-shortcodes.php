<?php

/**
 * The shortcodes class for the public-facing functionality of the plugin.
 *
 * @link       www.visamultimedia.com
 * @since      1.0.0
 *
 * @package    Vvb
 * @subpackage Vvb/public
 */

/**
 * The helper class for the public-facing functionality of the plugin.
 *
 * @package    Vvb
 * @subpackage Vvb/public
 * @author     Gabriele Coquillard <gabriele.coquillard@gmail.com>
 */
class Vvb_Public_Shortcodes {

	/**
	 * Undocumented variable
	 *
	 * @var [type]
	 */
	private $options;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->options = get_option( 'aec_options' );
		$this::add_shortocdes();
	}

	/**
	 * Undocumented function
	 *
	 * @since    1.0.0
	 */
	public function add_shortocdes() {

		add_shortcode( 'vvb_display_form', array( $this, 'vvb_display_form' ) );		

	}

	/**
	 * Undocumented function
	 *
	 * @param [type] $atts
	 * @return void
	 */
	public function vvb_display_form( $atts ){
		$atts = shortcode_atts(
            array(),
			$atts,
			'vvb_display_form'
		);

		ob_start();
		?>

		<div id="angular-app" ng-app="vvb" ng-controller="vvbController" ng-cloak ng-strict-di>

			<form name="vvbForm" novalidate>

				<input type="form.arrivalDate" name="">

				<input type="form.departDate" name="">

				<select ng-model="form.rooms" ng-options="n for n in [] | range:1:5"></select>

				<input type="submit" ng-disabled="vvbForm.$invalid" value="<?= __( 'Submit', 'vvb' ) ?>" />
			</form>

		</div>		

		<?php
		return ob_get_clean();
	}

}
