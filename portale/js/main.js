(function () {
  var app = angular.module('portale', ['ui.bootstrap', 'ngRoute']);

  // routing
  app.config(function($routeProvider) {
    
    $routeProvider
      .when('/primo-articolo', {
        templateUrl: '../wordpress/primo-articolo'
      })
      .otherwise({
        redirectTo: '/'
      });
  });

  app.controller("Controller", function($scope, $http) {

    // indirizzo di wordpress con wp-json plugin
    var wp = "/wordpress/wp-json/";

    // chiamata a WP API
    var call = "posts";

    $http.get( wp + call )
    .success(function(data, status, header, config) {
      $scope.posts = data;
    })
    .error(function(data, status, header, config) {
      alert("Errore");
    });

  });
  
})()
