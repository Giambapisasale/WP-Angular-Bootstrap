(function () {
  var app = angular.module('portale');

  app.controller("HomeController", function($scope, $routeParams, $http, $sce) {

    var call = "posts?filter[posts_per_page]=2&filter[order]=DESC";

    $http.get( app.wp + call )
    .success(function(data, status, header, config) {
      $scope.posts = data;
      for(var i in $scope.posts)
        $scope.posts[i].content = $sce.trustAsHtml(data[i].content);
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of CategoryController");
    });
  });

})()
