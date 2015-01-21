(function () {
  var app = angular.module('portale');

  app.controller("HomeController", function($scope, $http, $sce) {

    $scope.menu1 = app.comune_informa;
    $scope.menu2 = app.cultura_turismo;
    $scope.menu3 = app.servizi_online;

    // Il Comune Informa
    $http.get( app.wp + "menus/" + app.comune_informa )
    .success(function(data, status, header, config) {

      $scope.menu_comune_informa = Array();
      var root_parent = data.items[0].ID;
      var j = 0;

      for (var i = 0; i < data.items.length; i++)
      {
        if (data.items[i].parent == root_parent)
        {
          $scope.menu_comune_informa[j] = data.items[i];

          $scope.menu_comune_informa[j].url = "section/"+ app.comune_informa + "/" + $scope.menu_comune_informa[j].object + "/" + $scope.menu_comune_informa[j].object_id;

          j++;
        }
      }

    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of HomeController (menu comune_informa)");
    });

    // Cultura e Turismo
    $http.get( app.wp + "menus/" + app.cultura_turismo )
    .success(function(data, status, header, config) {

      $scope.cultura_turismo = Array();
      var root_parent = data.items[0].ID;
      var j = 0;

      for (var i = 0; i < data.items.length; i++)
      {
        if (data.items[i].parent == root_parent)
        {
          $scope.cultura_turismo[j] = data.items[i];

          $scope.cultura_turismo[j].url = "section/"+ app.cultura_turismo + "/" + $scope.cultura_turismo[j].object + "/" + $scope.cultura_turismo[j].object_id;

          j++;
        }
      }

    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of HomeController (menu cultura_turismo)");
    });

    // Servizi Online
    $http.get( app.wp + "menus/" + app.servizi_online )
    .success(function(data, status, header, config) {

      $scope.servizi_online = Array();
      var root_parent = data.items[0].ID;
      var j = 0;

      for (var i = 0; i < data.items.length; i++)
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
      console.log("Error in $http.get() of HomeController (menu servizi_online)");
    });

    // News
    var call = "posts?filter[posts_per_page]=2&filter[order]=DESC";

    $http.get( app.wp + call )
    .success(function(data, status, header, config) {
      $scope.posts = data;
      for (var i in $scope.posts)
      {
        $scope.posts[i].content = $sce.trustAsHtml(data[i].content);
      }
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of HomeController (news)");
    });
  });

})()
