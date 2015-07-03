/*jslint browser: true, white: true, plusplus: true, eqeq: true, es5: true, forin: true */
/*global angular, console, alert*/

(function () {
  'use strict';
  var app = angular.module('portale');

  app.controller("CategoryController", function($scope, $rootScope, $stateParams, $http, $sce) {

    $http.get( app.wp + "posts/types/posts/taxonomies/category/terms/" + $stateParams.id )
      .success(function(data, status, header, config) {

      $scope.category = data;
      $rootScope.selectedItem = $sce.trustAsHtml('<a href="./#/section/' + $stateParams.menu + '/category/' + $scope.category.ID + '">' + $scope.category.name + '</a>');

    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of CategoryController");
    });

    $http.get( app.wp + "posts?filter[cat]=" + $stateParams.id )
      .success(function(data, status, header, config) {
      var i;

      $scope.posts = data;

      for(i in $scope.posts)
      {
        $scope.posts[i].content = $sce.trustAsHtml(data[i].content);
      }

    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of CategoryController");
    });

  });

}());
