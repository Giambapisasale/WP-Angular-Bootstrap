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
	
	var user_data = $rootScope.$storage.token_;
    if (user_data.roles == "administrator")
    {
      $scope.permission = true;
	}
	
	
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
		  
		  f (menu.url.startsWith("#")) {
				menu.url = menu.url.substring(1, menu.url.length);
				
				if(menu.url.endsWith("@"))
				{
				menu.url = menu.url.substring(0, menu.url.length-1);
				if($scope.permission != true)return;
				}
				
				if (menu.url.length > 1 ) {
					menu.url = menu.url+"/";
				}
			}

          for (j = 0; j < data.items.length; j++) {
            submenu = data.items[j];

            if (submenu.parent == menu.ID) {
              if (submenu.url.startsWith("#")) {
                submenu.url = submenu.url.substring(1, submenu.url.length);
				
					if(submenu.url.endsWith("@"))
					{
					submenu.url = submenu.url.substring(0, submenu.url.length-1);
					if($scope.permission != true)return;
					}
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

  app.controller("AffissioniCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

    $http.get( "oauth/client.php?action=p&path=api/public/affissioni/" + $rootScope.$storage.token_.ID )
      .success(function(data, status, header, config) {
      $scope.affissioni = data;
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of AffissioniCtrl");
    });

  });

  app.controller("AffissioniDettaglioCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

    $http.get( "oauth/client.php?action=p&path=api/public/affissioni/dettaglio/" + $stateParams.id )
      .success(function(data, status, header, config) {
      if (data.length > 0) {
        $scope.affissioni = data[0];
      } else {
        console.log("Affissione " + $stateParams.id + " non esistente");
      }
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of AffissioniDettaglioCtrl");
    });

  });
  
  
  app.controller("VerificaCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

    $http.get( "oauth/client.php?action=p&path=api/public/verifica/" + $rootScope.$storage.token_.ID )
      .success(function(data, status, header, config) {
      $scope.verifica = data;
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of VerificaCtrl");
    });
	
	$scope.permission = false;
    var mdata = $rootScope.$storage.token_;
    if (mdata.roles == "administrator")
    {
		$scope.permission = true;
	}
  });
  
  app.controller("VerificaDettaglioCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

    $http.get( "oauth/client.php?action=p&path=api/public/verifica/dettaglio/" + $stateParams.id )
      .success(function(data, status, header, config) {
      if (data.length > 0) {
        $scope.verifica = data[0];
      } else {
        console.log("Verifica " + $stateParams.id + " non esistente");
      }
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of VerificaDettaglioCtrl");
    });
	
	$scope.permission = false;
    var mdata = $rootScope.$storage.token_;
    if (mdata.roles == "administrator")
    {
		$scope.permission = true;
	}
  });
  
  
  app.controller("VerificaAccettaCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

    $http.get( "oauth/client.php?action=p&path=api/public/verifica/accetta/" + $stateParams.id )
      .success(function(data, status, header, config) {
      if (data.length > 0) {
        $scope.verifica = data[0];
      } else {
        console.log("Verifica " + $stateParams.id + " non esistente");
      }
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of VerificaADettaglioCtrl");
    });
	
  });
  app.controller("VerificaRifiutaCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

    $http.get( "oauth/client.php?action=p&path=api/public/verifica/rifiuta/" + $stateParams.id )
      .success(function(data, status, header, config) {
      if (data.length > 0) {
        $scope.verifica = data[0];
      } else {
        console.log("Verifica " + $stateParams.id + " non esistente");
      }
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of VerificaRDettaglioCtrl");
    });

  });
 
 app.controller("LetturaCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {
	
	console.log("hello letture");
    $http.post( "oauth/client.php?action=p&path=api/public/acquedotto/"+$rootScope.$storage.token_.ID)
      .success(function(data, status, header, config) {
      $scope.verifica = data;
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of LetturaCtrl");
    });

  });
  
  app.controller("RegistrazioneCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {
	
    $http.get( "oauth/client.php?action=p&path=users/me/" )
        .success(function(data, status, header, config) {
        $scope.users = data;
      })
        .error(function(data, status, header, config) {
        console.log("Error in $http.get() of RegistrationCtrl (users)");
      });
	$scope.permission = false;
    var mdata = $rootScope.$storage.token_;
    if (mdata.roles == "administrator")
    {
		$scope.permission = true;
	}
  });
	 app.controller("VerificaUtentiCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

    $http.get( "oauth/client.php?action=p&path=api/public/utenti-verifica/" + $rootScope.$storage.token_.ID )
      .success(function(data, status, header, config) {
      $scope.verifica = data;
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of VerificaUtentiCtrl");
    });
	
	$scope.permission = false;
    var mdata = $rootScope.$storage.token_;
    if (mdata.roles == "administrator")
    {
		$scope.permission = true;
	}
  });
   app.controller("VerificaUtentiDettaglioCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

    $http.get( "oauth/client.php?action=p&path=api/public/utenti-verifica/utente/" + $stateParams.id )
      .success(function(data, status, header, config) {
      if (data.length > 0) {
        $scope.verifica = data[0];
      } else {
        console.log("Verifica " + $stateParams.id + " non esistente");
      }
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of VerificaUtenteDettaglioCtrl");
    });
	
	$scope.permission = false;
    var mdata = $rootScope.$storage.token_;
    if (mdata.roles == "administrator")
    {
		$scope.permission = true;
	}
  });
  app.controller("VerificaUtentiAccettaCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

    $http.get( "oauth/client.php?action=p&path=api/public/utenti-verifica/accetta/" + $stateParams.id )
      .success(function(data, status, header, config) {
      if (data.length > 0) {
        $scope.verifica = data[0];
      } else {
        console.log("Verifica " + $stateParams.id + " non esistente");
      }
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of VerificaUtenteAccettaCtrl");
    });
	
  });
  
  
    app.controller("VerificaUtentiRifiutaCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

    $http.get( "oauth/client.php?action=p&path=api/public/utenti-verifica/rifiuta/" + $stateParams.id )
      .success(function(data, status, header, config) {
      if (data.length > 0) {
        $scope.verifica = data[0];
      } else {
        console.log("Verifica " + $stateParams.id + " non esistente");
      }
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of VerificaUtenteRifiutaCtrl");
    });
  });
  
  app.controller("AdminCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

    $http.get( "oauth/client.php?action=p&path=api/public/admin/" + $stateParams.id )
      .success(function(data, status, header, config) {
		  
	$scope.token=data;  
	$scope.table=$stateParams.id; 
      if (data.length > 0) {
        $scope.verifica = data[0];
      } else {
        console.log("Admin " + $stateParams.id + " non esistente");
      }
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of AdminCtrl");
    });
  });
  
  app.controller("AdminImportCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

    $http.get( "oauth/client.php?action=p&path=api/public/admin-import/" + $stateParams.id )
      .success(function(data, status, header, config) {
		  
	$scope.token=data;  
	$scope.table=$stateParams.id; 
      if (data.length > 0) {
        $scope.verifica = data[0];
      } else {
        console.log("Admin import " + $stateParams.id + " non esistente");
      }
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of AdminImportCtrl");
    });
  });
  
   app.controller("AdminExportCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

    $http.get( "oauth/client.php?action=p&path=api/public/admin/export/" + $stateParams.id )
      .success(function(data, status, header, config) {
      if (data.length > 0) {
        $scope.verifica = data[0];
      } else {
        console.log("Admin " + $stateParams.id + " non esistente");
      }
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of AdminExportCtrl");
    });
  });
  
  app.controller("TestCtrl", function($scope, $http, $sce, $rootScope, $stateParams) {

  $http.get( "oauth/client.php?action=p&path=api/public/testmenu/" )
    .success(function(data, status, header, config) {
    $scope.affissioni = data;
  })
    .error(function(data, status, header, config) {
    console.log("Error in $http.get() of TestCtrl");
  });

});
	

}());
