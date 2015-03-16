(function () {
  var app = angular.module('portale', ['ui.router', 'ui.bootstrap', 'ngSanitize', 'uiRouterStyles', 'ngStorage']);

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

  app.controller('ModalDemoCtrl', function ($scope, $modal, $log, $rootScope) {
    $scope.username = "";
    $scope.display = "";
    $scope.img_src = "images/assets/login-icon.png";

    if($rootScope.$storage.token_ != null)
    {
      var data = $rootScope.$storage.token_;
      $scope.display = '{"display": "none"}';
      $scope.username = data.username;
      $scope.img_src = data.avatar;
      $scope.dim_avatar = '{"width" : "32px", "height" : "32px", "vertical-align" : "middle"}';
    }

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

  app.controller('StorageCtrl', function($scope, $localStorage, $rootScope) {
    $rootScope.$storage = $localStorage.$default({
      token_: $scope.tokens
    });
  });

})()

function close_modal() {
  document.getElementsByClassName('modal')[0].click();
}

function update_storage(data) {
  var scope = angular.element(document.getElementById("storage")).scope();
<<<<<<< HEAD
  scope.$storage.token_ = JSON.parse(data);
=======
  scope.$storage.token_ = angular.fromJson(data);
>>>>>>> e2632b60cf0de8c2d8b35f4aa6d24e440b9c7ad0
  //alert(scope.$storage.token_);
  close_modal();
  location.href = '../#/panel';
}
