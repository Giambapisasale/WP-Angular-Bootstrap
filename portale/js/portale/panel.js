function Main($scope) {
  $scope.myModel = {};
}

(function () {
  var app = angular.module('portale');



  app.controller("PanelController", function($scope, $http, $sce, $rootScope, $stateParams) {
    $scope.id = $stateParams.id;
    $rootScope.firstname = $rootScope.$storage.token_.first_name;
    $rootScope.lastname = $rootScope.$storage.token_.last_name;
    $rootScope.img = $rootScope.$storage.token_.avatar;

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
    $http.get( "oauth/client.php?action=p&path=api/public/contratto/" + $rootScope.$storage.token_.ID )
      .success(function(data, status, header, config) {
      $scope.contracts_ = data;
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PanelController (contracts)");
    });

    $scope.getid = function(id) {
      $scope.id_ = id;
    };
  });

  app.controller("PanelContractCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {
    $http.get( "oauth/client.php?action=p&path=api/public/contratto/" + $rootScope.$storage.token_.ID )
      .success(function(data, status, header, config) {
      $scope.contracts_ = data;
      $scope.details = $scope.contracts_.contracts[0];
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PanelController (contracts)");
    });

    $http.get( "oauth/client.php?action=p&path=api/public/contratto/dettaglio/" + $stateParams.id)
      .success(function(data, status, header, config) {
      $scope.contratto = data;
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PanelContractCtrl (contracts)");
    });

  });

})()
