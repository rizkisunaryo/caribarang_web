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

app.factory('suggestions', [
	function() {

		var o = {
			suggestions: []
		};

		o.getSuggestions = function(credential, callback) {
			$.ajax({
				url: API_SERVER_URI + '/api/suggestions/list',
				type: 'POST',
				dataType: 'json',
				success: function(data) {
					o.suggestions = data.hits.hits;
					callback();
				}.bind(this),
				error: function(xhr, status, err) {
					// EMPTY
				}.bind(this),
				data: JSON.stringify(credential)
			});

		}

		return o;
	}
]);

app.controller('MainCtrl', [
	'$scope',
	'$timeout',
	'master',
	'suggestions',
	function($scope, $timeout, master, suggestions) {
		$scope.categories = master.categories;
		$scope.getSuggestions = function(credential) {
			suggestions.getSuggestions(credential, function() {
                $scope.suggestions = suggestions.suggestions;
                $scope.$apply();
			});
		}
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