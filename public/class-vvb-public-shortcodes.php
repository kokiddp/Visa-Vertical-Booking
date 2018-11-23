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

		$this->options = get_option( 'vvb_options' );
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

			<form name="vvbForm" ng-init="form.url='<?= $this->options['url'] ?>';submit.id_albergo=<?= $this->options['id_albergo'] ?>;submit.id_stile=<?= $this->options['id_stile'] ?>;submit.dc=<?= $this->options['dc'] ?>" novalidate>

				<input type="date" ng-model="form.arrivalDate" min="{{Date() | date:'yyyy-MM-dd'}}" max="{{form.departDate | date:'yyyy-MM-dd'}}">

				<input type="date" ng-model="form.departDate" min="{{Date() | date:'yyyy-MM-dd'}}">

				<input type="button" ng-click="addRoom()" ng-disabled="form.rooms.length >= 5" value="<?= __( 'Add room', 'vvb' ) ?>" />
				<input type="button" ng-click="removeRoom()" ng-disabled="form.rooms.length == 1" value="<?= __( 'Remove room', 'vvb' ) ?>" />

				<div ng-repeat="x in form.rooms">
					<label><?= __( 'Adults', 'vvb' ) ?></label>
					<select ng-model="x.adulti" ng-options="n for n in [] | range:x.minAdulti:(x.maxAdulti - x.bambini + 1)"></select>
					<label><?= __( 'Children', 'vvb' ) ?></label>
					<select ng-model="x.bambini" ng-options="n for n in [] | range:x.minBambini:(x.maxBambini - x.adulti + 1)"></select>
				</div>

				<div>{{submit | json}}</div>

				<input type="submit" ng-click="submitForm()" ng-disabled="vvbForm.$invalid" value="<?= __( 'Submit', 'vvb' ) ?>" />
			</form>

		</div>		

		<?php
		return ob_get_clean();
	}

}
