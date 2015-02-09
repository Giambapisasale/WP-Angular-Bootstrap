function show_submenu(menu_)
{
  var seconds = document.getElementsByClassName("second");
  for (var i = 0; i < seconds.length; i++)
  {
    seconds[i].style.display = "none";
  }
  
  var sub_menu = menu_.getElementsByClassName("second");
  for (var i = 0; i < sub_menu.length; i++)
  {
    sub_menu[i].style.display = "block"; 
  }
  scrolltomenu();
}

function scrolltomenu()
{
  var el = document.getElementsByClassName("side-menu")[0];
  var sec_offset = document.getElementById("section").offsetTop;
  if((document.documentElement.scrollTop) > sec_offset)
    el.scrollIntoView();
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
          $scope.side_menu += '<li class="first" OnClick="scrolltomenu()"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a></li>\n';
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
        $scope.side_menu += '<li class="first" OnClick="scrolltomenu()"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a></li>\n';
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
