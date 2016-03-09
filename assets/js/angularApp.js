var app = angular.module('cariBarang', ['ui.router'])

app.config([
	'$stateProvider',
	'$urlRouterProvider',
	function($stateProvider, $urlRouterProvider) {

		$stateProvider
			.state('home', {
				url: '/home',
				templateUrl: 'assets/templates/home.html',
				controller: 'MainCtrl'
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
			})
			.state('list', {
				url: '/list/{category}/{keyword}/{minPrice}/{maxPrice}',
				templateUrl: 'assets/templates/list.html',
				controller: 'ListCtrl'
			})
			.state('listSl', {
				url: '/list/{category}/{keyword}/{minPrice}/{maxPrice}/',
				templateUrl: 'assets/templates/list.html',
				controller: 'ListCtrl'
			});

		$urlRouterProvider.otherwise('home');
	}
]);

app.factory('master', [
	function() {

		var o = {
			categories: [],
			sources: [],
			selectedSources: []
		};

		o.getCategories = function(callback) {
			$.ajax({
				url: API_SERVER_URI + '/api/category/list',
				type: 'GET',
				dataType: 'json',
				success: function(data) {
					// setTimeout(function() {
						o.categories = data;
						callback();
					// }, 100);
				}.bind(this),
				error: function(xhr, status, err) {
					// EMPTY
				}.bind(this)
			});
		}

		o.getSources = function(callback) {
			$.ajax({
				url: API_SERVER_URI + '/api/source/list',
				type: 'GET',
				dataType: 'json',
				success: function(data) {
					// setTimeout(function() {
						o.sources = data;
						callback();
					// }, 100);
				}.bind(this),
				error: function(xhr, status, err) {
					// EMPTY
				}.bind(this)
			});
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

		o.list = function(credential, callback) {
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

app.factory('popular', [
	function() {

		var o = {
			populars: []
		};

		o.list = function(criteria, callback) {
			$.ajax({
				url: API_SERVER_URI + '/api/popular/list',
				type: 'POST',
				dataType: 'json',
				success: function(data) {
					if (data != null && typeof data.hits.hits != 'undefined')
						o.populars = data.hits.hits;
					callback();
				}.bind(this),
				error: function(xhr, status, err) {
					// EMPTY
				}.bind(this),
				data: JSON.stringify(criteria)
			});

		}

		o.save = function(item) {
			$.ajax({
				url: API_SERVER_URI + '/api/popular/save',
				type: 'POST',
				dataType: 'json',
				success: function(data) {
					// EMPTY
				}.bind(this),
				error: function(xhr, status, err) {
					// EMPTY
				}.bind(this),
				data: JSON.stringify(item)
			});
		}

		return o;
	}
]);

app.controller('MainCtrl', [
	'$scope',
	'$timeout',
	'$location',
	'master',
	'helper',
	'suggestions',
	'popular',
	function($scope, $timeout, $location, master, helper, suggestions, popular) {
		$scope.getCategories = function() {
			master.getCategories(function() {
				$timeout(function() {
					$scope.categories = master.categories;
					$scope.$apply;
				}, 0);
			})
		}

		$scope.getSources = function() {
			master.getSources(function() {
				$timeout(function() {
					$scope.sources = master.sources;
					$scope.$apply;
				}, 0);
			})
		}

		$scope.selectedSources = [];

		$scope.toggleSource = function(sourceName) {
			var idx = $scope.selectedSources.indexOf(sourceName);

			// is currently selected
			if (idx > -1) {
				$scope.selectedSources.splice(idx, 1);
			}

			// is newly selected
			else {
				$scope.selectedSources.push(sourceName);
			}
		};

		$scope.getSuggestions = function(credential) {
			suggestions.list(credential, function() {
				$timeout(function() {
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
				}, 0);
			});
		}

		$scope.getPopular = function(criteria) {
			popular.list(criteria, function() {
				$timeout(function() {
					$scope.populars = popular.populars;
					if ($scope.populars.length > 0) {
						$scope.isPopularExist = true;
					};
					$scope.$apply();

					$scope.populars.forEach(function(obj) {
						var img = new Image();
						img.onload = function() {
							$('#popular-preload-image_' + obj._id).attr('src', obj._source.ImageUri);
						}
						img.src = obj._source.ImageUri;
					});
				}, 0);
			});
		}

		$scope.savePopular = function(uri) {
			popular.save({Uri:uri});
		}

		$scope.numberWithCommas = function(x) {
			var ret = helper.numberWithCommas(String(x));
			return ret;
		}

		$scope.search = function() {
			var category = escape($scope.category);
			var keyword = escape($scope.keyword);
			keyword = keyword.split('/').join('&#47;');
			var minPrice = escape($scope.minPrice);
			var maxPrice = escape($scope.maxPrice);
			$location.path('/list/'+category+'/'+keyword+'/'+minPrice+'/'+maxPrice);
		}
	}
]);

app.controller('ListCtrl', [
	'$scope',
	'$stateParams',
	function($scope, $stateParams) {
		$scope.category = unescape($stateParams.category);
		$scope.keyword = $stateParams.keyword.split('&#47;').join('/');
		$scope.keyword = unescape($scope.keyword);
		$scope.minPrice = unescape($stateParams.minPrice);
		$scope.maxPrice = unescape($stateParams.maxPrice);
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