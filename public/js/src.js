require('angular');
var moment = require('moment');
require('moment/locale/it');
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
        "$window",
        function($scope,$window) {

            $scope.internal = {
                minNights: parseInt(vvb_options.minNights),
                maxRooms: parseInt(vvb_options.maxRooms),
                maxPeople: parseInt(vvb_options.maxPeople),
                defaultAdults: parseInt(vvb_options.defaultAdults),
                minAdultsFirstRoom: parseInt(vvb_options.minAdultsFirstRoom),
                minAdultsOtherRooms: parseInt(vvb_options.minAdultsOtherRooms),
                minAgeChildren: parseInt(vvb_options.minAgeChildren),
                maxAgeChildren: parseInt(vvb_options.maxAgeChildren),
                minArrivalDate: moment(new Date()).startOf('day').toDate(),
                url: vvb_options.url,
                queryString: '',
            }
            $scope.internal.minDepartDate = moment(new Date()).startOf('day').add(parseInt($scope.internal.minNights), 'd').toDate();
            $scope.internal.arrival = moment($scope.internal.minArrivalDate).startOf('day');
            $scope.internal.depart = moment($scope.internal.minDepartDate).startOf('day');

            $scope.form = {
                arrivalDate: moment(new Date()).startOf('day').toDate(),
                departDate: moment(new Date()).startOf('day').add(parseInt($scope.internal.minNights), 'd').toDate(),
                rooms: [{
                    id: 1,
                    adulti: parseInt(vvb_options.defaultAdults),
                    bambini: 0,
                    minAdulti: parseInt(vvb_options.minAdultsFirstRoom),
                    maxAdulti: parseInt(vvb_options.maxPeople),
                    minBambini: 0,
                    maxBambini: parseInt(vvb_options.maxPeople),
                }],
                ages: [],
            }

            $scope.submit = {
                id_albergo: vvb_options.id_albergo,
                id_stile: vvb_options.id_stile,
                dc: vvb_options.dc,
                tot_adulti: 0,
                tot_bambini: 0,
                notti_1: 1,
                tot_camere: 1,
                lingua_int: 'ita',
            }

            $scope.$watch("form.rooms", function(){
                $scope.submit.tot_camere = $scope.form.rooms.length;
                $scope.submit.tot_adulti = _.sumBy($scope.form.rooms, function(r) { return r.adulti; });
                $scope.submit.tot_bambini = _.sumBy($scope.form.rooms, function(r) { return r.bambini; });
                _.forEach($scope.form.rooms, function(value){
                    _.set($scope.submit, 'adulti' + value.id, value.adulti);
                    _.set($scope.submit, 'bambini' + value.id, value.bambini);
                });
            }, true);

            $scope.$watch("form.ages", function(){
                _.forEach($scope.form.ages, function(value, key){
                    _.forEach(value, function(value2, key2){
                        _.set($scope.submit, 'st' + key + 'bamb' + key2, value2);
                    });
                });
            }, true);

            $scope.$watch("form.arrivalDate", function(){
                $scope.internal.arrival = moment($scope.form.arrivalDate).startOf('day');
                $scope.internal.depart = moment($scope.form.departDate).startOf('day');
                $scope.internal.minDepartDate = moment($scope.internal.arrival.toDate()).add(parseInt($scope.internal.minNights), 'd').toDate();
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
                    adulti: vvb_options.defaultAdults,
                    bambini: 0,
                    minAdulti: vvb_options.minAdultsOtherRooms,
                    maxAdulti: vvb_options.maxPeople,
                    minBambini: 0,
                    maxBambini: vvb_options.maxPeople,
                });
            }

            $scope.removeRoom = function(){
                $scope.form.rooms.splice(-1,1);
            }

            $scope.submitForm = function(){
                $scope.internal.queryString = _.reduce($scope.submit, function(result, value, key) { return (!_.isNull(value) && !_.isUndefined(value)) ? (result += key + '=' + value + '&') : result; }, '').slice(0, -1);
                $window.open($scope.internal.url+'?'+$scope.internal.queryString);
            }
        
    }]);
    
    app.filter('range', function() {
        return function(input, min, max) {
            min = parseInt(min);
            max = parseInt(max);
            for (var i=min; i<=max; i++)
                input.push(i);
            return input;
        };
    });

})( jQuery );