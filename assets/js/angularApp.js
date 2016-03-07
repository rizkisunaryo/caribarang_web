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

app.factory('helper', [
	function() {

		var o = {};

		o.numberWithCommas = function(x) {
			return numberWithCommas(x);
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
	'helper',
	'suggestions',
	function($scope, $timeout, master, helper, suggestions) {
		$scope.categories = master.categories;
		$scope.getSuggestions = function(credential) {
			suggestions.getSuggestions(credential, function() {
				$scope.suggestions = suggestions.suggestions;
				if ($scope.suggestions.length > 0) {
					$scope.isSuggestionsExist = true;
				};
				$scope.$apply();

				$scope.suggestions.forEach(function(suggestion) {
					var img = new Image();
					img.onload = function() {
						$('#suggestions-preload-image_' + suggestion._id).attr('src', suggestion._source.ImageUri);
					}
					img.src = suggestion._source.ImageUri;
				});

			});
		}
		$scope.numberWithCommas = function(x) {
			var ret = helper.numberWithCommas(String(x));
			return ret;
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