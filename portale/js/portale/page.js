(function () {
  var app = angular.module('portale');

  app.controller("PageController", function($scope, $routeParams, $http, $sce) {
    $http.get( app.wp + "pages/" + $routeParams.id )
    .success(function(data, status, header, config) {
      $scope.page = data;
      $scope.page.content = $sce.trustAsHtml(data.content);
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PageController");
    });
  });

})()
