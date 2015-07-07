/*jslint nomen: true, browser: true, white: true, plusplus: true, eqeq: true, es5: true, forin: true */
/*global angular, console, alert, scrolltomenu*/

(function () {
  'use strict';
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

      if (data.items === undefined) {
        console.log("Warning: there are no menus");
        return;
      }

      var i, j, menu, submenu;
      $scope.menus = [];


      for (i = 0; i < data.items.length; i++) {
        menu = data.items[i];

        if (menu.parent === 0) {
          menu.submenus = [];

          for (j = 0; j < data.items.length; j++) {
            submenu = data.items[j];

            if (submenu.parent == menu.ID) {
              if (submenu.url.startsWith("#")) {
                submenu.url = submenu.url.substring(1, submenu.url.length);
              } else {
                console.log("Error: URL of submenu " + submenu.title + " is not properly formatted");
              }

              menu.submenus.push(submenu);
            }
          }

          $scope.menus.push(menu);
        }
      }

    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PanelController (panel_menu)");
    });

    // qui occorre passare l'ID dell'utente loggato
    $http.get( "oauth/client.php?action=p&path=api/public/contratto/" + $rootScope.$storage.token_.ID )
      .success(function(data, status, header, config) {
      $scope.radio = "";
      if (data.contracts == "")
      {
        data.contracts = [];
        data.contracts[0] = {
          indirizzo : "Nessun Contratto Trovato",
          categoria : "",
          matricola : "",
          data : ""
        };
        $scope.radio = "{ 'display' : 'none' }";
      }
      $scope.contracts_ = data;
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PanelController (contracts) 1");
    });

    $scope.getid = function(id) {
      $scope.id_ = id;
    };

    $scope.shows = [];
    $scope.admin = [];
    $scope.show_sub = function(id) {
      var i;

      for (i in $scope.shows)
      {
        $scope.shows[i] = false;
        $scope.admin[i] = "";
      }

      if (!$scope.shows[id])
      {
        $scope.shows[id] = true;
        $scope.admin[id] = "admin-lateral";
      }
    };
  });

  app.controller("AcquedottoCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {
    $http.get( "oauth/client.php?action=p&path=api/public/contratto/" + $rootScope.$storage.token_.ID )
      .success(function(data, status, header, config) {
      $scope.contracts_ = data;
      $scope.details = $scope.contracts_.contracts[0];
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of AcquedottoCtrl (contracts) 2");
    });

    $http.get( "oauth/client.php?action=p&path=api/public/contratto/dettaglio/" + $stateParams.id)
      .success(function(data, status, header, config) {
      $scope.contratto = data;
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of AcquedottoCtrl (contracts) 3");
    });

    $scope.permission = false;
    var data = $rootScope.$storage.token_;
    if (data.roles == "administrator")
    {
      $scope.permission = true;

      // carica lista utenti
      $http.get( "oauth/client.php?action=p&path=users" )
        .success(function(data, status, header, config) {
        $scope.users = data;
      })
        .error(function(data, status, header, config) {
        console.log("Error in $http.get() of AcquedottoCtrl (users)");
      });
    }

  });

  app.controller("PubblicitaCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

    $http.get( "oauth/client.php?action=p&path=api/public/pubblicita/" + $rootScope.$storage.token_.ID )
      .success(function(data, status, header, config) {
      $scope.pubblicita = data;
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PubblicitaController");
    });

  });

  app.controller("PubblicitaDettaglioCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

    $http.get( "oauth/client.php?action=p&path=api/public/pubblicita/dettaglio/" + $stateParams.id )
      .success(function(data, status, header, config) {
      if (data.length > 0) {
        $scope.pubblicita = data[0];
      } else {
        console.log("Pubblicità " + $stateParams.id + " non esistente");
      }
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PubblicitaDettaglioController");
    });

  });

}());
