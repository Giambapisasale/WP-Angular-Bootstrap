(function () {
  var app = angular.module('portale');

  app.controller("CategoryController", function($scope, $routeParams, $http, $sce) {

    $http.get( app.wp + "posts/types/posts/taxonomies/category/terms/" + $routeParams.id )
    .success(function(data, status, header, config) {

      $scope.category = data;

    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of CategoryController");
    });

    $http.get( app.wp + "posts?filter[cat]=" + $routeParams.id )
    .success(function(data, status, header, config) {

      $scope.posts = data;

      for(var i in $scope.posts)
      {
        $scope.posts[i].content = $sce.trustAsHtml(data[i].content);
      }

    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of CategoryController");
    });

  });

})()
