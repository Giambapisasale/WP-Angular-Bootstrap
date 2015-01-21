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
      templateUrl: "partials/section.html",
      data: {
        css: 'css/section.css'
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
