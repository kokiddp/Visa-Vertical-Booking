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

				<input type="date" ng-model="form.arrivalDate">

				<input type="date" ng-model="form.departDate">

				<input type="button" ng-click="addRoom()" ng-disabled="form.rooms.length >= 5" value="<?= __( 'Add room', 'vvb' ) ?>" />
				<input type="button" ng-click="removeRoom()" ng-disabled="form.rooms.length == 1" value="<?= __( 'Remove room', 'vvb' ) ?>" />
				
				<div ng-repeat="x in form.rooms">
					<select ng-model="x.adulti">
						<option ng-repeat="n in [].constructor(5) track by $index+1" ng-selected="$index+1 == x.adulti">{{$index+1}}</option>
					</select>
					<select ng-model="x.bambini">
						<option ng-repeat="n in [].constructor(5) track by $index+1" ng-selected="$index+1 == x.bambini">{{$index+1}}</option>
					</select>
				</div>

				<input type="submit" ng-disabled="vvbForm.$invalid" value="<?= __( 'Submit', 'vvb' ) ?>" />
			</form>

		</div>		

		<?php
		return ob_get_clean();
	}

}
