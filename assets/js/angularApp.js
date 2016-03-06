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
				value: 'hp',
				label: 'HP'
			}, {
				value: 'test',
				label: 'Test'
			}];
		}

		return o;
	}
]);

app.controller('MainCtrl', [
	'$scope',
	'$window',
	'master',
	function($scope,$window,master) {
		$window.location.href = '#/test/1/';
		$scope.test = 'Hello world!';
		$scope.categories = master.categories
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