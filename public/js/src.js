require('angular');

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
            
	}]);

})( jQuery );