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
		add_shortcode( 'vvb_display_mini_form', array( $this, 'vvb_display_mini_form' ) );

	}

	/**
	 * Undocumented function
	 * 
	 * @since    1.0.0
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

		<div id="vvb" class="clearfix" ng-app="vvb" ng-controller="vvbController" ng-cloak ng-strict-di>

			<form name="vvbForm" novalidate>

				<div class="vvb_dates clearfix">
					<div class="vvb_date vvb_date_arrival clearfix">
						<label><?= __( 'Arrival date', 'visa-vertical-booking' ) ?></label>
						<input name="arrivalDate" type="date" ng-model="form.arrivalDate" ng-min="{{internal.minArrivalDate}}" min="{{internal.minArrivalDate | date:'yyyy-MM-dd'}}" required>
						<label class="validation-error" ng-if="vvbForm.arrivalDate.$invalid"><?= __( 'Invalid date!', 'visa-vertical-booking' ) ?></label>
					</div>
					<div class="vvb_date vvb_date_depart clearfix">
						<label><?= __( 'Departure date', 'visa-vertical-booking' ) ?></label>
						<input name="departDate" type="date" ng-model="form.departDate" ng-min="{{internal.minDepartDate}}" min="{{internal.minDepartDate | date:'yyyy-MM-dd'}}" required>
						<label class="validation-error" ng-if="vvbForm.departDate.$invalid"><?= __( 'Invalid date!', 'visa-vertical-booking' ) ?></label>
					</div>
				</div>

				<div class="vvb_rooms_controls clearfix">
					<label><?= __( 'Rooms', 'visa-vertical-booking' ) ?></label>
					<input type="button" ng-click="removeRoom()" ng-disabled="form.rooms.length == 1" value="<?= __( '-', 'visa-vertical-booking' ) ?>" />
					<input type="number" name="totalRooms" value="{{form.rooms.length}}" readonly/>
					<input type="button" ng-click="addRoom()" ng-disabled="form.rooms.length >= internal.maxRooms" value="<?= __( '+', 'visa-vertical-booking' ) ?>" />					
				</div>

				<div class="vvb_rooms clearfix">
					<div ng-repeat="x in form.rooms" class="vvb_room clearfix">
						<div class="people clearfix">
							<label><?= __( 'Room ', 'visa-vertical-booking' ) ?>{{x.id}}</label>
							<div class="adults clearfix">
								<label><?= __( 'Adults', 'visa-vertical-booking' ) ?></label>
								<select ng-model="x.adulti" ng-options="n for n in [] | range:x.minAdulti:(x.maxAdulti - x.bambini)"></select>
							</div>
							<div class="children clearfix">
								<label><?= __( 'Children', 'visa-vertical-booking' ) ?></label>
								<select ng-model="x.bambini" ng-options="n for n in [] | range:x.minBambini:(x.maxBambini - x.adulti)"></select>
							</div>
						</div>
						<div class="ages clearfix">
							<div class="age clearfix" ng-repeat="y in [] | range:1:(x.bambini)">
								<label><?= __( 'Child age ', 'visa-vertical-booking' ) ?>{{y}}</label>
								<select ng-model="form.ages[x.id][y]" ng-options="n for n in [] | range:(internal.minAgeChildren):(internal.maxAgeChildren)" ng-init="form.ages[x.id][y]=parseInt(vvb_options.minAgeChildren)" ng-required="true"></select>
								<label class="validation-error" ng-if="!form.ages[x.id][y] && form.ages[x.id][y] !== 0"><?= __( 'Select child age', 'visa-vertical-booking' ) ?></label>
							</div>
						</div>
					</div>
				</div>

				<div class="vvb_submit clearfix">
					<input type="submit" ng-click="submitForm()" ng-disabled="vvbForm.$invalid" value="<?= __( 'Submit', 'visa-vertical-booking' ) ?>" />
					<label class="validation-error" ng-if="vvbForm.$invalid"><?= __( 'There are one or more errors in your request. Please correct them before submitting.', 'visa-vertical-booking' ) ?></label>
				</div>
			</form>

		</div>		

		<?php
		return ob_get_clean();
	}

	/**
	 * Undocumented function
	 * 
	 * @since    1.2.0
	 *
	 * @param [type] $atts
	 * @return void
	 */
	public function vvb_display_mini_form( $atts ){
		$atts = shortcode_atts(
            array(),
			$atts,
			'vvb_display_mini_form'
		);

		ob_start();
		?>

		<div id="vvb" class="miniform clearfix" ng-app="vvb" ng-controller="vvbController" ng-cloak ng-strict-di>

			<form name="vvbForm" novalidate>

				<div class="vvb_dates clearfix">
					<div class="vvb_date vvb_date_arrival clearfix">
						<label><?= __( 'Arrival date', 'visa-vertical-booking' ) ?></label>
						<input name="arrivalDate" type="date" ng-model="form.arrivalDate" ng-min="{{internal.minArrivalDate}}" min="{{internal.minArrivalDate | date:'yyyy-MM-dd'}}" required>
						<label class="validation-error" ng-if="vvbForm.arrivalDate.$invalid"><?= __( 'Invalid date!', 'visa-vertical-booking' ) ?></label>
					</div>
					<div class="vvb_date vvb_date_depart clearfix">
						<label><?= __( 'Departure date', 'visa-vertical-booking' ) ?></label>
						<input name="departDate" type="date" ng-model="form.departDate" ng-min="{{internal.minDepartDate}}" min="{{internal.minDepartDate | date:'yyyy-MM-dd'}}" required>
						<label class="validation-error" ng-if="vvbForm.departDate.$invalid"><?= __( 'Invalid date!', 'visa-vertical-booking' ) ?></label>
					</div>
				</div>

				<div class="vvb_rooms_controls clearfix">
					<label><?= __( 'Rooms', 'visa-vertical-booking' ) ?></label>
					<input type="button" ng-click="removeRoom()" ng-disabled="form.rooms.length == 1" value="<?= __( '-', 'visa-vertical-booking' ) ?>" />
					<input type="number" name="totalRooms" value="{{form.rooms.length}}" readonly/>
					<input type="button" ng-click="addRoom()" ng-disabled="form.rooms.length >= internal.maxRooms" value="<?= __( '+', 'visa-vertical-booking' ) ?>" />					
				</div>

				<div class="vvb_submit clearfix">
					<input type="submit" ng-click="submitForm()" ng-disabled="vvbForm.$invalid" value="<?= __( 'Submit', 'visa-vertical-booking' ) ?>" />
					<label class="validation-error" ng-if="vvbForm.$invalid"><?= __( 'There are one or more errors in your request. Please correct them before submitting.', 'visa-vertical-booking' ) ?></label>
				</div>
			</form>

		</div>		

		<?php
		return ob_get_clean();
	}

}
