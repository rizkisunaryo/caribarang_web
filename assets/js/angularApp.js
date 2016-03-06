var app = angular.module('cariBarang', ['ui.router'])

app.config([
	'$stateProvider',
	'$urlRouterProvider',
	function($stateProvider, $urlRouterProvider) {

		$stateProvider
			.state('home', {
				url: '/home',
				templateUrl: 'assets/templates/home.html',
				controller: 'MainCtrl',
				resolve: {
					postPromise: ['master', function(master) {
						return master.getCategories();
					}]
				}
			})
			.state('test', {
				url: '/test/{id}',
				templateUrl: 'assets/templates/test.html',
				controller: 'TestCtrl',
			})
			.state('testSl', {
				url: '/test/{id}/',
				templateUrl: 'assets/templates/test.html',
				controller: 'TestCtrl',
			})
			.state('testLagi', {
				url: '/test/{id}/lagi/{lagiId}',
				templateUrl: 'assets/templates/test-lagi.html',
				controller: 'TestLagiCtrl',
			})
			.state('testLagiSl', {
				url: '/test/{id}/lagi/{lagiId}/',
				templateUrl: 'assets/templates/test-lagi.html',
				controller: 'TestLagiCtrl',
			});

		$urlRouterProvider.otherwise('home');
	}
]);

app.factory('helper', [
	function() {

		var o = {};

		o.isNumberKey = function(evt) {
			var charCode = (evt.which) ? evt.which : evt.keyCode
			return !(charCode > 31 && (charCode < 48 || charCode > 57));
		}

		o.numberWithCommas = function(x) {
			//remove commas
			retVal = x ? parseFloat(x.replace(/,/g, '')) : 0;
			if (retVal == 0) return '';

			//apply formatting
			return retVal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
		}

		return o;
	}
]);

app.factory('master', [
	function() {

		var o = {
			categories: []
		};

		o.getCategories = function() {
			o.categories = [{
				Category: 'hp',
				CategoryOrder: 0,
				Label: 'Semua handphone'
			}, {
				Category: 'test',
				CategoryOrder: 10,
				Label: 'Semua test'
			}];
		}

		return o;
	}
]);

app.controller('MainCtrl', [
	'$scope',
	'$window',
	'master',
	'helper',
	function($scope, $window, master, helper) {
		$scope.categories = master.categories;
		$scope.onlyNumbers = /^\d+$/;
	}
]);

app.controller('TestCtrl', [
	'$scope',
	'$stateParams',
	function($scope, $stateParams) {
		$scope.id = $stateParams.id;
	}
]);

app.controller('TestLagiCtrl', [
	'$scope',
	'$stateParams',
	function($scope, $stateParams) {
		$scope.id = $stateParams.id;
		$scope.lagiId = $stateParams.lagiId;
	}
]);

app.directive('validNumber', function() {
	return {
		require: '?ngModel',
		link: function(scope, element, attrs, ngModelCtrl) {
			if (!ngModelCtrl) {
				return;
			}

			ngModelCtrl.$parsers.push(function(x) {
				retVal = x ? parseFloat(x.replace(/,/g, '')) : 0;
				if (retVal == 0) return '';

				//apply formatting
				var theRet = retVal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
				if (x !== theRet) {
					ngModelCtrl.$setViewValue(theRet);
					ngModelCtrl.$render();
				}
				return theRet;
			});

			element.bind('keypress', function(evt) {
				var charCode = (evt.which) ? evt.which : evt.keyCode;
				return !(charCode > 31 && (charCode < 48 || charCode > 57));
			});
		}
	};
});