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
                arrivalDate: moment(new Date()).startOf('day').toDate(),
                departDate: moment(new Date()).startOf('day').add(1, 'd').toDate(),
                rooms: [{
                    id: 1,
                    adulti: 2,
                    bambini: 0,
                    minAdulti: 1,
                    maxAdulti: 5,
                    minBambini: 0,
                    maxBambini: 5
                }],
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

            $scope.internal = {
                minArrivalDate: moment(new Date()).startOf('day').toDate(),
                minDepartDate: moment(new Date()).startOf('day').add(1, 'd').toDate(),
                arrival: moment($scope.form.arrivalDate).startOf('day'),
                depart: moment($scope.form.departDate).startOf('day'),
                url: '',
                queryString: '',
            }

            $scope.$watch("form.rooms", function(){
                $scope.submit.tot_camere = $scope.form.rooms.length;
                $scope.submit.tot_adulti = _.sumBy($scope.form.rooms, function(r) { return r.adulti; });
                $scope.submit.tot_bambini = _.sumBy($scope.form.rooms, function(r) { return r.bambini; });
            }, true);

            $scope.$watch("form.arrivalDate", function(){
                $scope.internal.arrival = moment($scope.form.arrivalDate).startOf('day');
                $scope.internal.depart = moment($scope.form.departDate).startOf('day');
                $scope.internal.minDepartDate = moment($scope.internal.arrival.toDate()).add(1, 'd').toDate();
                $scope.submit.gg = $scope.internal.arrival.format('D');
                $scope.submit.mm = $scope.internal.arrival.format('M');
                $scope.submit.aa = $scope.internal.arrival.format('YYYY');
                $scope.submit.notti_1 = $scope.internal.depart.diff($scope.internal.arrival, 'days');
            }, true);

            $scope.$watch("form.departDate", function(){
                $scope.internal.arrival = moment($scope.form.arrivalDate).startOf('day');
                $scope.internal.depart = moment($scope.form.departDate).startOf('day');
                $scope.submit.ggf = $scope.internal.depart.format('D');
                $scope.submit.mmf = $scope.internal.depart.format('M');
                $scope.submit.aaf = $scope.internal.depart.format('YYYY');
                $scope.submit.notti_1 = $scope.internal.depart.diff($scope.internal.arrival, 'days');
            }, true);

            $scope.addRoom = function(){
                $scope.form.rooms.push({
                    id: _.last($scope.form.rooms).id+1,
                    adulti: 2,
                    bambini: 0,
                    minAdulti: 1,
                    maxAdulti: 5,
                    minBambini: 0,
                    maxBambini: 4,
                });
            }

            $scope.removeRoom = function(){
                $scope.form.rooms.splice(-1,1);
            }

            $scope.submitForm = function(){
                //$scope.internal.queryString = _.join(_.values($scope.submit), '&');
                $scope.internal.queryString = _.reduce(obj, function(result, value, key) { return (!_.isNull(value) && !_.isUndefined(value)) ? (result += key + '=' + value + '&') : result; }, '').slice(0, -1);
                $window.open($scope.internal.url+'?'+$scope.internal.queryString);
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