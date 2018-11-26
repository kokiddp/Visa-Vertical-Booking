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

			<form name="vvbForm" ng-init="
				internal.url='<?= $this->options['url'] ?>';
				submit.id_albergo=<?= $this->options['id_albergo'] ?>;
				submit.id_stile=<?= $this->options['id_stile'] ?>;
				submit.dc=<?= $this->options['dc'] ?>;
				internal.minNights=<?= $this->options['min_nights'] ?>;
				internal.maxRooms=<?= $this->options['max_rooms'] ?>;
				internal.maxPeople=<?= $this->options['max_people'] ?>;
				internal.defaultAdults=<?= $this->options['default_adults'] ?>;
				internal.minAdultsFirstRoom=<?= $this->options['min_adults_first_room'] ?>;
				internal.minAdultsOtherRooms=<?= $this->options['min_adults_other_rooms'] ?>;
				internal.maxAgeChildren=<?= $this->options['max_age_children'] ?>;
			" novalidate>

				<label><?= __( 'Arrival date', 'vvb' ) ?></label>
				<input name="arrivalDate" type="date" ng-model="form.arrivalDate" ng-min="{{internal.minArrivalDate}}" min="{{internal.minArrivalDate | date:'yyyy-MM-dd'}}">
				<label ng-if="vvbForm.arrivalDate.$invalid"><?= __( 'Invalid date!', 'vvb' ) ?></label>

				<label><?= __( 'Departure date', 'vvb' ) ?></label>
				<input name="departDate" type="date" ng-model="form.departDate" ng-min="{{internal.minDepartDate}}" min="{{internal.minDepartDate | date:'yyyy-MM-dd'}}">
				<label ng-if="vvbForm.departDate.$invalid"><?= __( 'Invalid date!', 'vvb' ) ?></label>

				<span><?= __( 'Rooms: ', 'vvb' ) ?>{{form.rooms.length}}</span>
				<input type="button" ng-click="addRoom()" ng-disabled="form.rooms.length >= internal.maxRooms" value="<?= __( '+', 'vvb' ) ?>" />
				<input type="button" ng-click="removeRoom()" ng-disabled="form.rooms.length == 1" value="<?= __( '-', 'vvb' ) ?>" />

				<div ng-repeat="x in form.rooms">
					<label><?= __( 'Adults', 'vvb' ) ?></label>
					<select ng-model="x.adulti" ng-options="n for n in [] | range:x.minAdulti:(x.maxAdulti - x.bambini + 1)"></select>
					<label><?= __( 'Children', 'vvb' ) ?></label>
					<select ng-model="x.bambini" ng-options="n for n in [] | range:x.minBambini:(x.maxBambini - x.adulti + 1)"></select>
					<div ng-repeat="y in x.bambini">
						<label><?= __( 'Child age', 'vvb' ) ?></label>
						<select ng-model="y.eta" ng-options="n for n in [] | range:0:(internal.maxAgeChildren + 1)"></select>
					</div>
				</div>

				<input type="submit" ng-click="submitForm()" ng-disabled="vvbForm.$invalid" value="<?= __( 'Submit', 'vvb' ) ?>" />
				<label ng-if="vvbForm.$invalid"><?= __( 'There are one or more errors in your request. Please correct them before submitting.', 'vvb' ) ?></label>
			</form>

		</div>		

		<?php
		return ob_get_clean();
	}

}
