(function () {

  var app = angular.module('portale');

  // indirizzo di wordpress con app.wp-json plugin
  app.wp = "../wordpress/wp-json/";

  // routing
  app.config(function($routeProvider) {

    $routeProvider
    .when('/home', {
      controller: 'HomeController',
      templateUrl: "partials/home.html"
    })
    .when('/post/:id', {
      controller: 'PostController',
      templateUrl: "partials/post.html"
    })
    .when('/category/:id', {
      controller: 'CategoryController',
      templateUrl: "partials/category.html"
    })
    .when('/page/:id', {
      controller: 'PageController',
      templateUrl: "partials/page.html"
    })
    .when('/author/:id', {
      controller: 'AuthorController',
      templateUrl: "partials/author.html"
    })
    .otherwise({
      redirectTo: '/home'
    });
  });

})();
