require('angular');
var moment = require('moment');
require('moment/locale/it');
require('moment-timezone');
var _ = require('lodash');

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
                rooms: [{
                    id: 1,
                    adulti: 2,
                    bambini: 0,
                    minAdulti: 1,
                    maxAdulti: 5,
                    minBambini: 0,
                    maxBambini: 5
                }],
                url: '',
            }

            $scope.submit = {
                id_albergo: '',
                id_stile: '',
                dc: '',
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
                lingua_int: 'ita',
            }

            $scope.$watch("form.rooms", function(){
                $scope.submit.tot_camere = $scope.form.rooms.length;
                $scope.submit.tot_adulti = _.sumBy($scope.form.rooms, function(r) { return r.adulti; });
                $scope.submit.tot_bambini = _.sumBy($scope.form.rooms, function(r) { return r.bambini; });
            }, true);

            $scope.$watch("form.arrivalDate", function(){
                var arrival = moment($scope.form.arrivalDate);
                var depart = moment($scope.form.arrivalDate);
                $scope.submit.gg = arrival.format('D');
                $scope.submit.mm = arrival.format('M');
                $scope.submit.aa = arrival.format('YYYY');
                $scope.submit.notti_1 = depart.diff(arrival, 'days');
            }, true);

            $scope.$watch("form.departDate", function(){
                var arrival = moment($scope.form.arrivalDate);
                var depart = moment($scope.form.arrivalDate);
                $scope.submit.ggf = depart.format('D');
                $scope.submit.mmf = depart.format('M');
                $scope.submit.aaf = depart.format('YYYY');
                $scope.submit.notti_1 = depart.diff(arrival, 'days');
            }, true);

            $scope.addRoom = function(){
                $scope.form.rooms.push({
                    id: _.last($scope.form.rooms).id+1,
                    adulti: 2,
                    bambini: 0,
                    minAdulti: 1,
                    maxAdulti: 5,
                    minBambini: 0,
                    maxBambini: 5
                });
            }

            $scope.removeRoom = function(){
                $scope.form.rooms.splice(-1,1);
            }

            $scope.submitForm = function(){
                //TODO:
                //-componi la querystring
                //-apri pagina in blank
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