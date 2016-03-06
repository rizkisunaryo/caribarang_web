var app = angular.module('cariBarang', ['ui.router'])

app.config([
	'$stateProvider',
	'$urlRouterProvider',
	'$httpProvider',
	function($stateProvider, $urlRouterProvider, $httpProvider) {

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



		$httpProvider.defaults.useXDomain = true;
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
	}
]);

app.config(['$httpProvider', function($httpProvider) {
        $httpProvider.defaults.useXDomain = true;
        delete $httpProvider.defaults.headers.common['X-Requested-With'];
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
	'$http',
	function($http) {

		var o = {
			suggestions: []
		};

		o.getSuggestions = function(credential) {
			console.log(JSON.stringify(credential));
			$http.post(API_SERVER_URI+'/api/suggestions/list', credential, {headers: {'Content-Type': 'application/json'}}).success(function(data){
    // o.suggestions.push(data);
    angular.copy(data.hits.hits, o.suggestions);
    console.log(o.suggestions);
  });

			// $http({
   //          url: API_SERVER_URI+'/api/suggestions/list',
   //          method: "POST",
   //          data: credential,
   //          headers: {
   //                'access-control-allow-origin': '*'
   //     },
   //      }).success(function (data, status, headers, config) {
   //              angular.copy(data.hits.hits, o.suggestions);
   //          }).error(function (data, status, headers, config) {
   //              // $scope.status = status + ' ' + headers;
   //          });

		}

		return o;
	}
]);

app.controller('MainCtrl', [
	'$scope',
	'$window',
	'master',
	'suggestions',
	function($scope, $window, master, suggestions) {
		$scope.categories = master.categories;
		$scope.getSuggestions = function(credential) {
			suggestions.getSuggestions(credential);
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