(function () {
  var app = angular.module('portale', ['ui.router', 'ui.bootstrap', 'ngSanitize', 'uiRouterStyles']);

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

  app.controller('ModalDemoCtrl', function ($scope, $modal, $log) {

    $scope.items = ['item1', 'item2', 'item3'];
    $scope.open = function (size) {

      var modalInstance = $modal.open({
        template: '<iframe class="login_ifr" src="oauth/client.php"></iframe>',
        controller: 'ModalInstanceCtrl',
        size: size,
        resolve: {
          items: function () {
            return $scope.items;
          }
        }
      });

      modalInstance.result.then(function (selectedItem) {
        $scope.selected = selectedItem;
      }, function () {
        $log.info('Modal dismissed at: ' + new Date());
      });
    };
  });

  app.controller('ModalInstanceCtrl', function ($scope, $modalInstance, items) {
    $scope.items = items;
    $scope.selected = {
      item: $scope.items[0]
    };

    $scope.ok = function () {
      $modalInstance.close($scope.selected.item);
    };

    $scope.cancel = function () {
      $modalInstance.dismiss('cancel');
    };
  });

})()