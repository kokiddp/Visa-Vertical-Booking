require('angular');
var moment = require('moment');
require('moment/locale/it');
require('moment-timezone');

(function( $ ) {
	'use strict';

	/**
	 * On DOM ready:
	 */
	$(function() {	
		console.log('Visa Vertical Booking by Gabriele Coquillard @ VisaMultimedia');	
	});

	/**
	 * Angular spapp:
	 */
    var app = angular.module('vvb',[]);
    
    app.config(['$compileProvider', function($compileProvider) {
        $compileProvider.debugInfoEnabled(false);
        $compileProvider.commentDirectivesEnabled(false);
        $compileProvider.cssClassDirectivesEnabled(false);
    }]);

    app.controller('vvbController',[
        "$scope",
        "$http",
        "$httpParamSerializerJQLike",
        "$window",
        function($scope,$http,$httpParamSerializerJQLike,$window) {

            $scope.form = {
                arrivalDate: new Date(),
                departDate: new Date(),
                rooms: 1,
            }
            
    }]);
    
    app.filter('range', function() {
        return function(input, min, max) {
            min = parseInt(min);
            max = parseInt(max);
            for (var i=min; i<max; i++)
                input.push(i);
            return input;
        };
    });

})( jQuery );