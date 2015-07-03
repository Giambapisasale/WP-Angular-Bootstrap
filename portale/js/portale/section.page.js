/*jslint browser: true, white: true, plusplus: true, eqeq: true, es5: true, forin: true */
/*global angular, console, alert*/

(function () {
  'use strict';
  var app = angular.module('portale');

  app.controller("PageController", function($scope, $rootScope, $stateParams, $http, $sce) {

    $http.get( app.wp + "pages/" + $stateParams.id )
      .success(function(data, status, header, config) {
      $scope.page = data;
      $scope.page.content = $sce.trustAsHtml(data.content);
      $rootScope.selectedItem = $sce.trustAsHtml('<a href="./#/section/' + $stateParams.menu + '/page/' + $scope.page.ID + '">' + $scope.page.title + '</a>');
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PageController");
    });
  });

}());
