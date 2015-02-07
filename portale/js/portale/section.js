function show_submenu(menu_)
{
  var seconds = document.getElementsByClassName("first");
  for (var i = 0; i < seconds.length; i++)
  {
    if(seconds[i].getElementsByTagName("ul")[0] != null)
    {
//    seconds[i].getElementsByTagName("ul")[0].style.display = "block";
      seconds[i].getElementsByTagName("ul")[0].className = "disappear";
    }
  }

  var menu_ul = menu_.getElementsByTagName("ul")[0];
  if (menu_ul.className == "appear")
  {
    menu_ul.className = "disappear";
  }
  else
  {
    menu_ul.className = "appear";
  }
}

(function () {
  var app = angular.module('portale');

  app.controller("SectionController", function($scope, $rootScope, $http, $stateParams, $sce) {

    $scope.menu1 = app.comune_informa;
    $scope.menu2 = app.cultura_turismo;
    $scope.menu3 = app.servizi_online;
    $scope.selectedMenu = $stateParams.menu;
    $rootScope.selectedItem = "";

    $http.get( app.wp + "menus/" + $stateParams.menu )
    .success(function(data, status, header, config) {

      data.items.sort(function(a,b) { return parseInt(a.order) - parseInt(b.order) } );
      $scope.selectedMenuName = '<a href="./#/section/' + $stateParams.menu + '/' + data.items[0].object + '/' + data.items[0].object_id + '">' + data.items[0].title + '</a>';

      $scope.side_menu = "";

      var root_parent = data.items[0].ID;
      var i = 1;

      for (/* i = 1 */; i < data.items.length-1; i++)
      {
        // console.log(data.items[i]);

        if ((data.items[i].parent == root_parent) && (data.items[i+1].parent == root_parent))
        {
          $scope.side_menu += '<li class="first"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a></li>\n';
        }
        else if ((data.items[i].parent == root_parent) && (data.items[i+1].parent != root_parent))
        {
          $scope.side_menu += '<li class="first" OnClick="show_submenu(this)"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a>\n<ul>\n';
        }
        else if ((data.items[i].parent != root_parent) && (data.items[i+1].parent == root_parent))
        {
          $scope.side_menu += '<li class="second"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a></li>\n</ul>\n</li>\n';
        }
        else
        {
          $scope.side_menu += '<li class="second"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a></li>\n';
        }
      }
          
      if (data.items[i].parent == root_parent)
      {
        $scope.side_menu += '<li class="first"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a></li>\n';
      }
      else
      {
        $scope.side_menu += '<li class="second"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a></li>\n</ul>\n</li>\n';
      }
      
      $scope.side_menu = $sce.trustAsHtml($scope.side_menu);
      
    })
    .error(function(data, status, header, config) {
      console.log("Error in $http.get() of SectionController");
    });

  });
})()
