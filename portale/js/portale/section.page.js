(function () {
  var app = angular.module('portale');

  app.controller("PageController", function($scope, $rootScope, $stateParams, $http, $sce) {

    $http.get( app.wp + "pages/" + $stateParams.id )
    .success(function(data, status, header, config) {
      $scope.page = data;
      $scope.page.content = $sce.trustAsHtml(data.content);
      $rootScope.selectedItem = $sce.trustAsHtml($scope.page.title);
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PageController");
    });
  });

})()
