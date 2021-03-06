var app = angular.module('cariDulu', ['ui.router'])

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
			.state('list', {
				url: '/list/{category}/{keyword}/{minPrice}/{maxPrice}/{sources}',
				templateUrl: 'assets/templates/list.html',
				controller: 'ListCtrl'
			})
			.state('listSl', {
				url: '/list/{category}/{keyword}/{minPrice}/{maxPrice}/{sources}/',
				templateUrl: 'assets/templates/list.html',
				controller: 'ListCtrl'
			})
			.state('listPageno', {
				url: '/list/{category}/{keyword}/{minPrice}/{maxPrice}/{sources}/{pageNo}',
				templateUrl: 'assets/templates/list.html',
				controller: 'ListCtrl'
			})
			.state('listPagenoSl', {
				url: '/list/{category}/{keyword}/{minPrice}/{maxPrice}/{sources}/{pageNo}/',
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
			if (o.categories.length <= 0) {
				$.ajax({
					url: API_SERVER_URI + '/api/category/list',
					type: 'GET',
					dataType: 'json',
					success: function(data) {
						o.categories = data;
						callback();
					}.bind(this),
					error: function(xhr, status, err) {
						// EMPTY
					}.bind(this)
				});
			} else {
				callback();
			}
		}

		o.getSources = function(callback) {
			if (o.categories.length <= 0) {
				$.ajax({
					url: API_SERVER_URI + '/api/source/list',
					type: 'GET',
					dataType: 'json',
					success: function(data) {
						o.sources = data;
						callback();
					}.bind(this),
					error: function(xhr, status, err) {
						// EMPTY
					}.bind(this)
				});
			} else {
				callback();
			}
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

		o.escapeUrl = function(pStr) {
			var str = pStr;
			if (typeof str === 'undefined') return '';

			str = escape(str);
			str = str.split('/').join('&#47;');
			return str;
		}

		o.unescapeUrl = function(pStr) {
			var str = pStr
			if (typeof str === 'undefined') return '';

			str = str.split('&#47;').join('/');
			str = unescape(str);
			return str;
		}

		o.checkFbLoginBtn = function() {
			function checkFbLoginBtnInside() {
				if (isFbInit==0) {
					setTimeout(checkFbLoginBtnInside, 500);
				} else {
					$('#fb-div').html($('#fb-div-master').html());
				}
			}
			checkFbLoginBtnInside();
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
					if (data != null)
						o.populars = data;
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

app.factory('search', [
	function() {

		var o = {
			items: [],
			count: 0
		};

		o.list = function(criteria, callback) {
			$.ajax({
				url: API_SERVER_URI + '/api/search/list',
				type: 'POST',
				dataType: 'json',
				success: function(data) {
					if (data != null && typeof data.hits.hits != 'undefined') {
						o.items = data.hits.hits;
						o.count = data.hits.total;
					}
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
				url: API_SERVER_URI + '/api/search/save',
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
	'search',
	function($scope, $timeout, $location, master, helper, suggestions, popular, search) {
		// helper.checkFbLoginBtn();

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
					$scope.populars = [];
					var popularI = 0;
					popular.populars.forEach(function(obj) {
						$scope.populars[popularI] = obj;
						$scope.populars[popularI].Id = popularI;
						popularI++;
					});
					if ($scope.populars.length > 0) {
						$scope.isPopularExist = true;
					};
					$scope.$apply();

					$scope.populars.forEach(function(obj) {
						var img = new Image();
						img.onload = function() {
							$('#popular-preload-image_' + obj.Id).attr('src', obj.ImageUri);
						}
						img.src = obj.ImageUri;
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
			// $('body').removeClass('modal-open');
			var keyword = typeof $scope.keyword === 'undefined' ? '' : $scope.keyword;
			// search.save({
			// 	Id: id,
			// 	Token: token,
			// 	LoginType: 'fb',
			// 	Keyword: keyword.trim()
			// });

			var category = helper.escapeUrl($scope.category);
			var keyword = helper.escapeUrl($scope.keyword);
			var minPrice = helper.escapeUrl($scope.minPrice);
			var maxPrice = helper.escapeUrl($scope.maxPrice);
			var sources = '';
			var sourcesI = 0;
			$scope.selectedSources.forEach(function(str) {
				if (str.trim()!='') {
					if (sourcesI>0) sources+='|||';
					sources += str;
					sourcesI++;
				}
			});
			sources = helper.escapeUrl(sources);
			$location.path('/list/'+category+'/'+keyword+'/'+minPrice+'/'+maxPrice+'/'+sources);
		}
	}
]);

app.controller('ListCtrl', [
	'$scope',
	'$stateParams',
	'$timeout',
	'$location',
	'$sce',
	'helper',
	'search',
	'master',
	'popular',
	function($scope, $stateParams, $timeout, $location, $sce, helper, search, master, popular) {
		// helper.checkFbLoginBtn();

		$scope.category = helper.unescapeUrl($stateParams.category);
		$scope.keyword = helper.unescapeUrl($stateParams.keyword);
		$scope.minPrice = helper.unescapeUrl($stateParams.minPrice);
		$scope.maxPrice = helper.unescapeUrl($stateParams.maxPrice);
		var sourcesUrl = helper.unescapeUrl($stateParams.sources);
		$scope.selectedSources = sourcesUrl.split('|||');
		var emptyArrayIndex = $scope.selectedSources.indexOf('');
		if (emptyArrayIndex > -1) $scope.selectedSources.splice(emptyArrayIndex, 1);
		$scope.pageNo = helper.unescapeUrl($stateParams.pageNo);
		if ($scope.pageNo=='') $scope.pageNo = '1';

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

		$scope.listItems = function() {
			var from = ((Number($scope.pageNo) - 1) * 10).toString();
			search.list({
				Category: $scope.category,
				Keyword: $scope.keyword,
				MinPrice: $scope.minPrice.split(',').join(''), 
				MaxPrice: $scope.maxPrice.split(',').join(''),
				Sources: $scope.selectedSources,
				Size: '10',
				From: from
			}, function() {
				$timeout(function() {
					var rows = Math.floor(search.items.length / 5);
					if (rows != search.items.length/5) rows++;

					$scope.items = [];
					for (var i=0; i<rows; i++) {
						$scope.items[i] = search.items.slice(i*5, (i+1)*5);
					};
					$scope.$apply;

					search.items.forEach(function(obj) {
						var img = new Image();
						img.onload = function() {
							$('#item-preload-image_' + obj._id).attr('src', obj._source.ImageUri);
						}
						img.src = obj._source.ImageUri;
					});




					$scope.showLinkFirst = function() {
						if (Number($scope.pageNo)!=1) {
							return true;
						};
						return false;
					}

					var lastPage = search.count / 10;
					if (lastPage != Math.floor(lastPage)) {
						lastPage = Math.floor(lastPage) + 1;
					}
					$scope.showLinkLast = function() {
						if (Number($scope.pageNo)!=lastPage) {
							return true;
						};
						return false;
					}

					$scope.linkFirst = '/#/list/'+helper.escapeUrl($stateParams.category)+'/'+helper.escapeUrl($stateParams.keyword)+'/'+helper.escapeUrl($stateParams.minPrice)+'/'+helper.escapeUrl($stateParams.maxPrice)+'/'+helper.escapeUrl($stateParams.sources);
					// $scope.linkPrev = $scope.linkFirst + '/' + ((Number($scope.pageNo))-1);
					
					var link1No = $scope.pageNo - 2;
					// if (link1No<1) link1No = 1;
					if (link1No>lastPage-4) link1No = lastPage - 4;
					if (link1No<=0) link1No = 1;

					$scope.link1 = $scope.linkFirst + '/' + link1No;
					$scope.link1Label = link1No;
					if ($scope.pageNo == link1No) $scope.link1Class = 'active';

					$scope.link2 = $scope.linkFirst + '/' + (link1No+1);
					$scope.link2Label = link1No + 1;
					if ($scope.pageNo == link1No + 1) $scope.link2Class = 'active';
					$scope.showLink2 = lastPage >= link1No + 1;

					$scope.link3 = $scope.linkFirst + '/' + (link1No+2);
					$scope.link3Label = link1No + 2;
					if ($scope.pageNo == link1No + 2) $scope.link3Class = 'active';
					$scope.showLink3 = lastPage >= link1No + 2;

					$scope.link4 = $scope.linkFirst + '/' + (link1No+3);
					$scope.link4Label = link1No + 3;
					if ($scope.pageNo == link1No + 3) $scope.link4Class = 'active';
					$scope.showLink4 = lastPage >= link1No + 3;

					$scope.link5 = $scope.linkFirst + '/' + (link1No+4);
					$scope.link5Label = link1No + 4;
					if ($scope.pageNo == link1No + 4) $scope.link5Class = 'active';
					$scope.showLink5 = lastPage >= link1No + 4;

					// $scope.linkNext = $scope.linkFirst + '/' + ((Number($scope.pageNo))+1);
					$scope.linkLast = $scope.linkFirst + '/' + lastPage;
				}, 0);
			})
		}

		$scope.numberWithCommas = function(x) {
			var ret = helper.numberWithCommas(String(x));
			return ret;
		}

		$scope.savePopular = function(uri) {
			popular.save({Uri:uri});
		}

		$scope.search = function() {
			$('#myModal').modal('hide');
			$timeout(function() {
				var category = helper.escapeUrl($scope.category);
				var keyword = helper.escapeUrl($scope.keyword);
				var minPrice = helper.escapeUrl($scope.minPrice);
				var maxPrice = helper.escapeUrl($scope.maxPrice);
				var sources = '';
				var sourcesI = 0;
				$scope.selectedSources.forEach(function(str) {
					if (str.trim()!='') {
						if (sourcesI>0) sources+='|||';
						sources += str;
						sourcesI++;
					}
				});
				sources = helper.escapeUrl(sources);
				$location.path('/list/'+category+'/'+keyword+'/'+minPrice+'/'+maxPrice+'/'+sources);
			}, 500);
		}
	}
]);

// app.controller('TestCtrl', [
// 	'$scope',
// 	'$stateParams',
// 	function($scope, $stateParams) {
// 		$scope.id = $stateParams.id;
// 	}
// ]);

// app.controller('TestLagiCtrl', [
// 	'$scope',
// 	'$stateParams',
// 	function($scope, $stateParams) {
// 		$scope.id = $stateParams.id;
// 		$scope.lagiId = $stateParams.lagiId;
// 	}
// ]);