(function () {
  var app = angular.module('portale', ['ui.bootstrap', 'ngRoute', 'ngSanitize']);

  // indirizzo di wordpress con wp-json plugin
  var wp = "/wordpress/wp-json/";

  // routing
  app.config(function($routeProvider) {

    $routeProvider
    .when('/post/:id', {
      controller: 'PostController',
      templateUrl: "partials/post.html"
    })
    .when('/category/:id', {
      controller: 'CategoryController',
      templateUrl: "partials/category.html"
    })
    .when('/page/:id', {
      controller: 'PageController',
      templateUrl: "partials/page.html"
    })
    .when('/author/:id', {
      controller: 'AuthorController',
      templateUrl: "partials/author.html"
    })
    .otherwise({
      controller: 'HomeController',
      templateUrl: "partials/home.html"
    });
  });

  app.controller("HomeController", function($scope, $routeParams, $http) {
  });

  app.controller("PostController", function($scope, $routeParams, $http, $sce) {
    $http.get( wp + "posts/" + $routeParams.id )
    .success(function(data, status, header, config) {
      $scope.post = data;
      $scope.post.content = $sce.trustAsHtml(data.content);
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PostController");
    });
  });

  app.controller("CategoryController", function($scope, $routeParams, $http, $sce) {
    $http.get( wp + "posts?filter[cat]=" + $routeParams.id )
    .success(function(data, status, header, config) {
      $scope.posts = data;
      for(var i in $scope.posts)
        $scope.posts[i].content = $sce.trustAsHtml(data[i].content);
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of CategoryController");
    });
  });

  app.controller("PageController", function($scope, $routeParams, $http, $sce) {
    $http.get( wp + "pages/" + $routeParams.id )
    .success(function(data, status, header, config) {
      $scope.page = data;
      $scope.page.content = $sce.trustAsHtml(data.content);
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PageController");
    });
  });

  app.controller("AuthorController", function($scope, $routeParams, $http, $sce) {
    $http.get( wp + "posts?filter[author]=" + $routeParams.id )
    .success(function(data, status, header, config) {
      $scope.posts = data;
      $scope.posts.content = $sce.trustAsHtml(data.content);
      for(var i in $scope.posts)
        $scope.posts[i].content = $sce.trustAsHtml(data[i].content);
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of AuthorController");
    });
  });

  app.controller("MenuController", function($scope, $http) {
    $http.get( wp + "posts/types/posts/taxonomies/category/terms" )
    .success(function(data, status, header, config) {
      $scope.categories = data;
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of MenuController (categories)");
    });

    $http.get( wp + "pages" )
    .success(function(data, status, header, config) {
      $scope.pages = data;
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of MenuController (pages)");
    });
  });

})()
