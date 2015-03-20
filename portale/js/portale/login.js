(function () {
  var app = angular.module('portale');

  app.controller('ModalDemoCtrl', function ($scope, $modal, $log, $rootScope) {
    $scope.userdata = {
      "firstname" : "",
      "lastname" : "",
      "display" : "",
      "img_src" : "images/assets/login-icon.png",
      "logged" : '{ "display" : "none" }'
    };

    if($rootScope.$storage.token_ != null)
    {
      var data = $rootScope.$storage.token_;
      $scope.userdata.logged = '{ "display" : "inline-block" }';
      $scope.userdata.display = '{"display": "none"}';
      $scope.userdata.firstname = data.first_name;
      $scope.userdata.lastname = data.last_name;
      $scope.userdata.img_src = data.avatar;
      $scope.userdata.dim_avatar = '{"width" : "32px", "height" : "32px", "vertical-align" : "middle"}';
    }

    $scope.logout = function(loc) {
      $rootScope.$storage.token_ = null;
      $scope.userdata = {
        "firstname" : "",
        "lastname" : "",
        "display" : "",
        "img_src" : "images/assets/login-icon.png",
        "logged" : '{ "display" : "none" }'
      };
      location.href = '#/home';
      if(loc == "home") { /* refresh */ }
    };

    $scope.items = ['item1', 'item2', 'item3'];
    $scope.open = function (size) {

      var modalInstance = $modal.open({
        template: '<iframe class="login_ifr" src="oauth/client.php?action=request_token"></iframe>',
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
  scope.$storage.token_ = JSON.parse(data);
  //alert(scope.$storage.token_);
  close_modal();
  location.href = '../#/panel/';
}
