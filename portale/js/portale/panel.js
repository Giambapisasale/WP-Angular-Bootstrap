function Main($scope) {
  $scope.myModel = {};
}

(function () {
  var app = angular.module('portale');

  app.controller("PanelController", function($scope, $http, $sce) {
    $http.get( app.wp )
      .success(function(data, status, header, config) {
      $scope.name = data.name;
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PanelController (name)");
    });

    $http.get( app.wp + "menus/28" )
      .success(function(data, status, header, config) {
      $scope.panel_menu = data;
      $scope.panel_menu.items[0].img = 'tap.png';
      $scope.panel_menu.items[1].img = 'empty.png';
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PanelController (panel_menu)");
    });


    $http.get( "js/portale/contracts.json" )
      .success(function(data, status, header, config) {
      $scope.contracts_ = data;
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PanelController (contracts)");
    });
  });

})()
