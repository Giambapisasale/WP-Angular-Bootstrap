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
  if(window.pageYOffset > sec_offset)
  {
    window.scrollTo(0,375);
  }
}

(function () {
  var app = angular.module('portale');

  app.controller("SectionController", function($scope, $rootScope, $http, $stateParams, $sce, $filter) {

    $scope.selectedMenu = $stateParams.menu;
    $rootScope.selectedItem = "";

    $http.get( app.wp + "menus/29" )
      .success(function(data, status, header, config) {

      $scope.menus = [];
      var menu;
      var j = 0;

      for (var i  = 0; i < data.items.length && j < 3; i++)
      {
        if(data.items[i].parent == 0)
        {
          $scope.menus[j] = data.items[i];

          if($scope.menus[j].ID == $stateParams.menu)
            menu = $scope.menus[j];

          j++;
        }
      }

      //    data.items.sort(function(a,b) { return parseInt(a.order) - parseInt(b.order) } );

      $scope.selectedMenuName = '<a href="./#/section/' + $stateParams.menu + '/' + menu.object + '/' + menu.object_id + '">' + menu.title + '</a>';

      $scope.side_menu = "";

      var root_parent = $stateParams.menu;
      var IDs = new Array();
      var i = 0;

      for (i = 0; i < data.items.length; i++)
      {
        if(data.items[i].parent == root_parent)
          IDs[i] = data.items[i].ID;
        else
        {
          var parent_item = $filter('filter')(data.items, { ID : data.items[i].parent })[0];

          if(parent_item.parent == root_parent)
            IDs[i] = data.items[i].ID;
        }
      }

      for (i = 0; i < data.items.length-1; i++)
      {
        for (var j = 0; j < IDs.length; j++)
        {
          if( data.items[i].ID == IDs[j] )
          {
            if ((data.items[i].parent == root_parent) && (data.items[i+1].parent == root_parent))
              $scope.side_menu += '<li class="first" OnClick="scrolltomenu()"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a></li>\n';
            else if ((data.items[i].parent == root_parent) && (data.items[i+1].parent != root_parent))
              $scope.side_menu += '<li class="first" OnClick="show_submenu(this)"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a>\n<ul>\n';
            else if ((data.items[i].parent != root_parent) && (data.items[i+1].parent == root_parent))
              $scope.side_menu += '<li class="second"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a></li>\n</ul>\n</li>\n';
            else
              $scope.side_menu += '<li class="second"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a></li>\n';

            break;
          }
        }
      }

      for (var j = 0; j < IDs.length; j++)
      {
        if( data.items[data.items.length-1].ID == IDs[j] )
        {
          if (data.items[i].parent == root_parent)
          {
            $scope.side_menu += '<li class="first" OnClick="scrolltomenu()"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a></li>\n';
          }
          else
          {
            $scope.side_menu += '<li class="second"><a href="./#/section/' + $stateParams.menu + '/' + data.items[i].object + '/' + data.items[i].object_id + '">' + data.items[i].title + '</a></li>\n</ul>\n</li>\n';
          }
          break;
        }
      }

      $scope.side_menu = $sce.trustAsHtml($scope.side_menu);

    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of SectionController");
    });

  });
})()
