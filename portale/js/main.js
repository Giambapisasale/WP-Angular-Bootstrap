(function () {
  var app = angular.module('portale', ['ui.bootstrap', 'ngRoute', 'ngSanitize']);

  // indirizzo di wordpress con wp-json plugin
  var wp = "/wordpress/wp-json/";

  // routing
  app.config(function($routeProvider) {
    
    $routeProvider
      .when('/:param', {
        controller: 'RouteController',
        template: "{{ param }}"
      })
      .otherwise({
        redirectTo: '/'
      });
  });
  
  app.controller("RouteController", function($scope, $routeParams, $http) {
    $http.get( wp + "posts/" + $routeParams.param )
    .success(function(data, status, header, config) {
      $scope.param = data.content;
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of RouteController");
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

  app.controller("Controller", function($scope, $http) {

    // chiamata a WP API
    var call = "posts";

    $http.get( wp + call )
    .success(function(data, status, header, config) {
      $scope.posts = data;
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of Controller");
    });

  });
  
})()
