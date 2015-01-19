(function () {
  var app = angular.module('portale');

  app.controller("MenuController", function($scope, $http) {
    $http.get( app.wp + "posts/types/posts/taxonomies/category/terms" )
    .success(function(data, status, header, config) {
      $scope.categories = data;
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of MenuController (categories)");
    });

    $http.get( app.wp + "pages" )
    .success(function(data, status, header, config) {
      $scope.pages = data;
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of MenuController (pages)");
    });

  });
})()
