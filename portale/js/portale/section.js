(function () {
  var app = angular.module('portale');

  app.controller("SectionController", function($scope, $http) {

    $scope.menu1 = app.comune_informa;
    $scope.menu2 = app.cultura_turismo;
    $scope.menu3 = app.servizi_online;

    $http.get( app.wp + "posts/types/posts/taxonomies/category/terms" )
    .success(function(data, status, header, config) {


    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of SectionController");
    });

  });
})()
