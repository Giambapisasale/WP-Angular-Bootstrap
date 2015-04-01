(function () {

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
      .state('panel.admin', {
      url: 'admin',
      data: {
        css:  'css/panel.css'
      },
      views: {
        '': {
          controller: 'PanelContractCtrl',
          templateUrl: "partials/panel.admin.html"
        }
      }
    })
      .state('panel.contract', {
      url: ':id',
      data: {
        css:  'css/panel.css'
      },
      views: {
        '': {
          controller: 'PanelContractCtrl',
          templateUrl: "partials/panel.contract.html"
        }
      }
    });
  });

})();
