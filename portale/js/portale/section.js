(function () {
  var app = angular.module('portale');

  app.controller("SectionController", function($scope, $http, $stateParams) {

    $scope.menu1 = app.comune_informa;
    $scope.menu2 = app.cultura_turismo;
    $scope.menu3 = app.servizi_online;
    $scope.selectedMenu = $stateParams.menu;

    $http.get( app.wp + "menus/" + $stateParams.menu )
    .success(function(data, status, header, config) {

      data.items.sort(function(a,b) { return parseInt(a.order) - parseInt(b.order) } );

      $scope.side_menu = "";

      var root_parent = data.items[0].ID;

      for (var i = 1; i < data.items.length; i++)
      {
        console.log(data.items[i]);

        if (data.items[i].parent == root_parent)
        {
          $scope.side_menu += '<li class="first"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a></li>\n';
        }
        else
        {
          $scope.side_menu += '<li class="second"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a></li>\n';
        }
      }

    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of SectionController");
    });

  });
})()
