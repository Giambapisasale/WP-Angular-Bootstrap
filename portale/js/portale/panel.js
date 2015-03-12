(function () {
  var app = angular.module('portale');

  app.controller("PanelController", function($scope, $http) {
    $http.get( "contracts.json" )
    .success(function(data, status, header, config) {
      $scope.contracts = data;
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PanelController (contracts)");
    });

  });
})()
