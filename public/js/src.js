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
        moment.locale('it');
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
                rooms: [
                    {
                        id: 1,
                        adulti: 2,
                        bambini: 0
                    }
                ],
            }

            $scope.submit = {
                tot_camere: 0,
                tot_adulti: 0,
                tot_bambini: 0,
                gg: 1,
                mm: 1,
                aa: 1970,
                ggf: 2,
                mmf: 1,
                aaf: 1970,
                notti_1: 1,
                tot_camere: 1,
                notti_1: 1,
                lingua_int: 'ita'
            }

            $scope.addRoom = function(){
                $scope.form.rooms.push({
                    id: $scope.form.rooms[$scope.form.rooms.length-1].id+1,
                    adulti: 2,
                    bambini: 0
                });
            }

            $scope.removeRoom = function(){
                $scope.form.rooms.splice(-1,1);
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