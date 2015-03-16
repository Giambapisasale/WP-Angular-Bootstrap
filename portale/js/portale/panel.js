function Main($scope) {
  $scope.myModel = {};
}

(function () {
  var app = angular.module('portale');
  
  
  
  app.controller("PanelController", function($scope, $http, $sce) {
	var scope = angular.element(document.getElementById("storage")).scope();
	
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

    // qui occorre passare l'ID dell'utente loggato
    $http.get( "oauth/client.php?action=p&path=api/public/contratto/" + scope.$storage.token_.ID )
      .success(function(data, status, header, config) {
      $scope.contracts_ = data;
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PanelController (contracts)");
    });
  });

})()
