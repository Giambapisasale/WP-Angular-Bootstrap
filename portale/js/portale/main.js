(function () {
  var app = angular.module('portale', ['ui.bootstrap', 'ngRoute', 'ngSanitize', 'routeStyles']);

  app.controller("HomeController", function($scope, $routeParams, $http, $sce) {
    $http.get( app.wp + "posts/" )
    .success(function(data, status, header, config) {
      $scope.post = data;
      $scope.post.content = $sce.trustAsHtml(data.content);
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PostController");
    });
  });

})()
