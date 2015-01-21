(function () {
  var app = angular.module('portale');

  app.controller("PostController", function($scope, $stateParams, $http, $sce) {
    $http.get( app.wp + "posts/" + $stateParams.id )
    .success(function(data, status, header, config) {
      $scope.post = data;
      $scope.post.content = $sce.trustAsHtml(data.content);
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PostController");
    });
  });

})()
