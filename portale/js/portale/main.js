(function () {
  var app = angular.module('portale', ['ui.router', 'ui.bootstrap', 'ngSanitize', 'uiRouterStyles']);

  app.controller("HomeController", function($scope, $stateParams, $http, $sce) {
    $http.get( app.wp + "posts/" )
    .success(function(data, status, header, config) {
      $scope.post = data;
      $scope.post.content = $sce.trustAsHtml(data.content);
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of HomeController");
    });
  });

})()
