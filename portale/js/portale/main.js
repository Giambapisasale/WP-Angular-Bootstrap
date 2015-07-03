/*jslint browser: true, white: true, plusplus: true, eqeq: true, es5: true, forin: true */
/*global angular, console, alert*/

(function () {
  'use strict';
  var app = angular.module('portale', ['ui.router', 'ui.bootstrap', 'ngSanitize', 'uiRouterStyles', 'ngStorage', 'chieffancypants.loadingBar']);

  app.controller("HomeController", function($scope, $stateParams, $http, $sce) {
    $http.get( app.wp + "posts/" )
      .success(function(data, status, header, config) {
      $scope.post = data;
      $scope.post.content = $sce.trustAsHtml(data.content);
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of HomeController");
    });
  });

  //loading bar
  app.config(function(cfpLoadingBarProvider) {
    cfpLoadingBarProvider.includeSpinner = true;
  });

  app.controller('LoadingBarCtrl', function ($scope, $http, $timeout, cfpLoadingBar) {
    $scope.start = function() {
      cfpLoadingBar.start();
    };

    $scope.complete = function () {
      cfpLoadingBar.complete();
    };

    // fake the initial load so first time users can see it right away:
    $scope.start();
    $scope.fakeIntro = true;
    $timeout(function() {
      $scope.complete();
      $scope.fakeIntro = false;
    }, 750);

  });

}());
