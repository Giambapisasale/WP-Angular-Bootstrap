(function () {
  var app = angular.module('portale', ['ui.bootstrap']);

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
