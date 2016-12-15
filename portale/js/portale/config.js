/*jslint browser: true, white: true, plusplus: true, eqeq: true, es5: true, forin: true */
/*global angular, console, alert*/

(function () {
  'use strict';

  var app = angular.module('portale');

  // indirizzo di wordpress con app.wp-json plugin
  app.wp = "../wordpress/wp-json/";

  // routing
  app.config(function($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise("/home");

    $stateProvider
      .state('home', {
      url: '/home',
      data: {
        css: 'css/home.css'
      },
      views: {
        '': {
          controller: 'HomeController',
          templateUrl: "partials/home.html"
        },
        'footer@home': {
          controller: 'FooterController',
          templateUrl: 'partials/footer.html'
        }
      }
    })
      .state('section', {
      url: '/section/:menu/',
      data: {
        css: 'css/section.css'
      },
      views: {
        '': {
          controller: 'SectionController',
          templateUrl: "partials/section.html"
        },
        'footer@section': {
          controller: 'FooterController',
          templateUrl: 'partials/footer.html'
        }
      }
    })
      .state('section.post', {
      url: 'post/:id',
      controller: 'PostController',
      templateUrl: "partials/section.post.html"
    })
      .state('section.category', {
      url: 'category/:id',
      controller: 'CategoryController',
      templateUrl: "partials/section.category.html",
    })
      .state('section.page', {
      url: 'page/:id',
      controller: 'PageController',
      templateUrl: "partials/section.page.html"
    })
      .state('panel', {
      url: '/panel/',
      data: {
        css:  'css/panel.css'
      },
      views: {
        '': {
          controller: 'PanelController',
          templateUrl: "partials/panel.html"
        }
      }
    })
      .state('panel.contratti-acquedotto', {
      url: 'contratti-acquedotto/',
      views: {
        '': {
          controller: 'AcquedottoCtrl',
          templateUrl: "partials/panel.contratti-acquedotto.html"
        }
      }
    })
      .state('panel.inserisci-contratto-acquedotto', {
      url: 'inserisci-contratto-acquedotto/',
      views: {
        '': {
          controller: 'AcquedottoCtrl',
          templateUrl: "partials/panel.inserisci-contratto-acquedotto.html"
        }
      }
    })
	 
      .state('panel.contratto-acquedotto', {
      url: 'contratti-acquedotto/:id',
      views: {
        '': {
          controller: 'AcquedottoCtrl',
          templateUrl: "partials/panel.contratto-acquedotto.html"
        }
      }
    })
    .state('panel.pubblicita', {
      url: 'pubblicita/',
      views: {
        '': {
          controller: 'PubblicitaCtrl',
          templateUrl: "partials/panel.pubblicita.html"
        }
      }
    })
    .state('panel.pubblicita-dettaglio', {
      url: 'pubblicita/:id',
      views: {
        '': {
          controller: 'PubblicitaDettaglioCtrl',
          templateUrl: "partials/panel.pubblicita-dettaglio.html"
        }
      }
    })
    .state('panel.affissioni', {
      url: 'affissioni/',
      views: {
        '': {
          controller: 'AffissioniCtrl',
          templateUrl: "partials/panel.affissioni.html"
        }
      }
    })
    .state('panel.affissioni-dettaglio', {
      url: 'affissioni/:id',
      views: {
        '': {
          controller: 'AffissioniDettaglioCtrl',
          templateUrl: "partials/panel.affissioni-dettaglio.html"
        }
      }
    })
	.state('panel.verifica', {
	  url: 'verifica/',
	  views: {
		'': {
		  controller: 'VerificaCtrl',
		  templateUrl: "partials/panel.verifica.html"
		}
	  }
	})
	
	.state('panel.verifica-dettaglio', {
	  url: 'verifica/:id',
	  views: {
		'': {
		  controller: 'VerificaDettaglioCtrl',
		  templateUrl: "partials/panel.verifica-dettaglio.html"
		}
	  }
	})
	.state('panel.verifica-accetta', {
	  url: 'verifica/accetta/:id',
	  views: {
		'': {
		  controller: 'VerificaAccettaCtrl',
		  templateUrl: "partials/panel.verifica-dettaglio.html"
		}
	  }
	})
	.state('panel.verifica-rifiuta', {
	  url: 'verifica/rifiuta/:id',
	  views: {
		'': {
		  controller: 'VerificaRifiutaCtrl',
		  templateUrl: "partials/panel.verifica-dettaglio.html"
		}
	  }
	})
	  .state('panel.acquedotto', {
      url: 'acquedotto/',
      views: {
        '': {
          controller: 'LetturaCtrl',
          templateUrl: "partials/panel.contratto-acquedotto.html"
        }
      }
    })
	.state('panel.utenti-verifica', {
	  url: 'utenti-verifica/',
	  views: {
		'': {
		  controller: 'VerificaUtentiCtrl',
		  templateUrl: "partials/panel.utenti-verifica.html"
		}
	  }
	})
	.state('panel.utenti-verifica-dettaglio', {
	  url: 'utenti-verifica/utente/:id',
	  views: {
		'': {
		  controller: 'VerificaUtentiDettaglioCtrl',
		  templateUrl: "partials/panel.utenti-verifica-dettaglio.html"
		}
	  }
	})
	.state('panel.utenti-verifica-accetta', {
	  url: 'utenti-verifica/accetta/:id',
	  views: {
		'': {
		  controller: 'VerificaUtentiAccettaCtrl',
		  templateUrl: "partials/panel.utenti-verifica-dettaglio.html"
		}
	  }
	})
	.state('panel.utenti-verifica-rifiuta', {
	  url: 'utenti-verifica/rifiuta/:id',
	  views: {
		'': {
		  controller: 'VerificaUtentiRifiutaCtrl',
		  templateUrl: "partials/panel.utenti-verifica-dettaglio.html"
		}
	  }
	})
	.state('panel.registrazione', {
	  url: 'registrazione/',
	  views: {
		'': {
		  controller: 'RegistrazioneCtrl',
		  templateUrl: "partials/panel.registrazione.html"
		}
	  }
	})
	.state('panel.testmenu', {
      url: 'testmenu/',
      views: {
        '': {
          controller: 'TestCtrl',
          templateUrl: "partials/panel.testmenu.html"
        }
      }
    })
	.state('panel.errore', {
	  url: 'errore/',
	  views: {
		'': {
		  controller: 'ErroreCtrl',
		  templateUrl: "partials/panel.errore.html"
		}
	  }
	})
	.state('panel.success', {
	  url: 'success/',
	  views: {
		'': {
		  controller: 'SuccessCtrl',
		  templateUrl: "partials/panel.success.html"
		}
	  }
	})
	.state('panel.admin', {
	  url: 'admin/:id',
	  views: {
		'': {
		  controller: 'AdminCtrl',
		  templateUrl: "partials/panel.admin.html"
		}
	  }
	})
	.state('panel.admin-export', {
	  url: 'admin/export/:id',
	  views: {
		'': {
		  controller: 'AdminExportCtrl',
		  templateUrl: "partials/panel.admin-export.html"
		}
	  }
	})
	.state('panel.admin-import', {
	  url: 'admin-import/:id',
	  views: {
		'': {
		  controller: 'AdminImportCtrl',
		  templateUrl: "partials/panel.admin-import.html"
		}
	  }
	});
	
	
	
	
	
	
  });

}());
