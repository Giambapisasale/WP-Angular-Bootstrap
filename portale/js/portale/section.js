(function () {
  var app = angular.module('portale');

  app.controller("SectionController", function($scope, $http) {

    $http.get( app.wp + "posts/types/posts/taxonomies/category/terms" )
    .success(function(data, status, header, config) {


    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of SectionController");
    });

  });
})()
