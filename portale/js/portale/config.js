(function () {

  var app = angular.module('portale');

  // indirizzo di wordpress con app.wp-json plugin
  app.wp = "../wordpress/wp-json/";

  // ID menu principali
  app.comune_informa  = 25;
  app.cultura_turismo = 26;
  app.servizi_online  = 27;

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
      url: '/section/:menu',
      data: {
        css: 'css/section.css'
      },
      views: {
        '': {
          templateUrl: "partials/section.html"
        },
        'footer@section': {
          controller: 'FooterController',
          templateUrl: 'partials/footer.html'
        }
      }
    })
    .state('section.post', {
      url: '/post/:id',
      controller: 'PostController',
      templateUrl: "partials/section.post.html"
    })
    .state('section.category', {
      url: '/category/:id',
      controller: 'CategoryController',
      templateUrl: "partials/section.category.html",
    })
    .state('section.page', {
      url: '/page/:id',
      controller: 'PageController',
      templateUrl: "partials/section.page.html"
    });
  });

})();
