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
      controller: 'HomeController',
      templateUrl: "partials/home.html"
    })
    .state('post', {
      url: '/post/:id',
      controller: 'PostController',
      templateUrl: "partials/post.html"
    })
    .state('category', {
      url: '/category/:id',
      controller: 'CategoryController',
      templateUrl: "partials/category.html",
    })
    .state('page', {
      url: '/page/:id',
      controller: 'PageController',
      templateUrl: "partials/page.html"
    })
    .state('author', {
      url: '/author/:id',
      controller: 'AuthorController',
      templateUrl: "partials/author.html"
    });
  });

})();
