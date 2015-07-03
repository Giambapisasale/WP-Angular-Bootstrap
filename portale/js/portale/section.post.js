/*jslint browser: true, white: true, plusplus: true, eqeq: true, es5: true, forin: true */
/*global angular, console, alert*/

(function () {
  'use strict';
  var app = angular.module('portale');

  app.controller("PostController", function($scope, $rootScope, $stateParams, $http, $sce) {
    $http.get( app.wp + "posts/" + $stateParams.id )
      .success(function(data, status, header, config) {
      $scope.post = data;
      $scope.post.content = $sce.trustAsHtml(data.content);
      $rootScope.selectedItem = $sce.trustAsHtml('<a href="./#/section/' + $stateParams.menu + '/post/' + $scope.post.ID + '">' + $scope.post.title + '</a>');
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PostController");
    });
  });

}());
