/*jslint browser: true, white: true, plusplus: true, eqeq: true, es5: true, forin: true */
/*global angular, console, alert*/

(function () {
  'use strict';

  var app = angular.module('portale');

  app.controller("HomeController", function($scope, $rootScope, $http, $sce) {

    $http.get( app.wp + "menus/29" )
      .success(function(data, status, header, config) {
      var i, j, root_parent;

      $rootScope.menus = [];
      j = 0;

      for (i  = 0; i < data.items.length && j < 3; i++)
      {
        if (data.items[i].parent == 0)
        {
          $rootScope.menus[j] = data.items[i];
          j++;
        }
      }

      // ID menu principali
      app.comune_informa  = $rootScope.menus[0].ID;
      app.cultura_turismo = $rootScope.menus[1].ID;
      app.servizi_online  = $rootScope.menus[2].ID;

      // Il Comune Informa
      $scope.menu_comune_informa = [];
      root_parent = $rootScope.menus[0].ID;
      j = 0;

      for (i = 0; i < data.items.length; i++)
      {
        if (data.items[i].parent == root_parent)
        {
          $scope.menu_comune_informa[j] = data.items[i];

          $scope.menu_comune_informa[j].url = "section/"+ app.comune_informa + "/" + $scope.menu_comune_informa[j].object + "/" + $scope.menu_comune_informa[j].object_id;

          j++;
        }
      }

      // Cultura e Turismo
      $scope.cultura_turismo = [];
      root_parent = $rootScope.menus[1].ID;
      j = 0;

      for (i = 0; i < data.items.length; i++)
      {
        if (data.items[i].parent == root_parent)
        {
          $scope.cultura_turismo[j] = data.items[i];

          $scope.cultura_turismo[j].url = "section/"+ app.cultura_turismo + "/" + $scope.cultura_turismo[j].object + "/" + $scope.cultura_turismo[j].object_id;

          j++;
        }
      }

      // Servizi Online
      $scope.servizi_online = [];
      root_parent = $rootScope.menus[2].ID;
      j = 0;

      for (i = 0; i < data.items.length; i++)
      {
        if (data.items[i].parent == root_parent)
        {
          $scope.servizi_online[j] = data.items[i];

          $scope.servizi_online[j].url = "section/"+ app.servizi_online + "/" + $scope.servizi_online[j].object + "/" + $scope.servizi_online[j].object_id;

          j++;
        }
      }

    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of HomeController (menus)");
    });

    // News
    var j,
        call = "posts?filter[posts_per_page]=2&filter[order]=DESC";

    $http.get( app.wp + call )
      .success(function(data, status, header, config) {
      var i;
      $scope.posts = data;
      for (i in $scope.posts)
      {
        $scope.posts[i].content = $sce.trustAsHtml(data[i].content);
      }
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of HomeController (news)");
    });

    $scope.stickyposts = [];
    j = 0;
    $http.get( app.wp + "posts/" )
      .success(function(data, status, header, config) {
      var i;
      for(i = 0; i < data.length; i++)
      {
        if (i == 3 || data[i].sticky == false)
        {
          break;
        }
        else
        {
          $scope.stickyposts[i] = data[i];
          j++;
        }
      }
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of HomeController (post in evidenza)");
    });

  });

}());
