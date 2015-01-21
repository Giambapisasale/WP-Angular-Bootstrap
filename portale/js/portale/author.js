(function () {
  var app = angular.module('portale');

  app.controller("AuthorController", function($scope, $stateParams, $http, $sce) {
    $http.get( app.wp + "posts?filter[author]=" + $stateParams.id )
    .success(function(data, status, header, config) {
      $scope.posts = data;
      $scope.posts.content = $sce.trustAsHtml(data.content);
      for(var i in $scope.posts)
        $scope.posts[i].content = $sce.trustAsHtml(data[i].content);
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of AuthorController");
    });
  });

})()
