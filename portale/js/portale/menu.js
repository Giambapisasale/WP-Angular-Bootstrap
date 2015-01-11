(function () {
  var app = angular.module('portale');

  app.controller("MenuController", function($scope, $http) {
    $http.get( app.wp + "posts/types/posts/taxonomies/category/terms" )
    .success(function(data, status, header, config) {
      $scope.categories = data;
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of MenuController (categories)");
    });

    $http.get( app.wp + "pages" )
    .success(function(data, status, header, config) {
      $scope.pages = data;
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of MenuController (pages)");
    });

    $http.get( app.wp + "menus" )
    .success(function(data, status, header, config) {
      $scope.menu_list = data;      
      $http.get( app.wp + "menus/" + $scope.menu_list[0].ID)
        .success(function(data, status, header, config) {
          $scope.menus = data;
          for(var i = 0; i < $scope.menus.items.length; i++)
          {
            var link = "";
            var url = $scope.menus.items[i];
            link += $scope.menus.items[i].object;
            link += "/";
            link += $scope.menus.items[i].object_id;
            $scope.menus.items[i].url = link;
          }
        })
        .error(function(data, status, header, config) {
          console.log("Error in $http.get() of MenuController (menu)");
        });

    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of MenuController (menus)");
    });
    
    
  });
})()
