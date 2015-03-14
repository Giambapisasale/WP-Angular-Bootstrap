function Main($scope) {
  $scope.myModel = {};
}

(function () {
  var app = angular.module('portale');

  app.controller("PanelController", function($scope, $http) {
    $http.get( app.wp )
      .success(function(data, status, header, config) {
      $scope.name = data.name;
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PanelController (name)");
    });

    $http.get( app.wp + "menus/27" )
      .success(function(data, status, header, config) {
      $scope.panel_menu = data;
      $scope.panel_menu.items.shift();
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PanelController (panel_menu)");
    });


    $http.get( "js/portale/contracts.json" )
      .success(function(data, status, header, config) {
      $scope.contracts_ = data;
    })
      .error(function(data, status, header, config) {
      console.log("Error in $http.get() of PanelController (contracts)");
    });

  });

  app.directive('buttonToggle', function() {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function($scope, element, attr, ctrl) {
        var classToToggle = attr.buttonToggle;
        element.bind('click', function() {
          var checked = ctrl.$viewValue;
          $scope.$apply(function(scope) {
            ctrl.$setViewValue(!checked);
          });
        });

        $scope.$watch(attr.ngModel, function(newValue, oldValue) {
          newValue ? element.addClass(classToToggle) : element.removeClass(classToToggle);
        });
      }
    };
  });

})()
