(function () {
  var app = angular.module('portale');

  app.controller('ModalDemoCtrl', function ($scope, $modal, $log, $rootScope, $http) {
    $rootScope.userdata = {
      firstname : "",
      lastname : "",
      display : "",
      img_src : "images/assets/login-icon.png",
      logged : '{ "display" : "none" }',
      dim_avatar : '{"width" : "16px", "height" : "16px", "vertical-align" : "middle"}'
    };

    if($rootScope.$storage.token_ != null)
    {
      var data = $rootScope.$storage.token_;
      $rootScope.userdata = {
        logged : '{ "display" : "inline-block" }',
        display : '{"display": "none"}',
        firstname : data.first_name,
        lastname : data.last_name,
        img_src : data.avatar,
        dim_avatar : '{"width" : "32px", "height" : "32px", "vertical-align" : "middle"}'
      };
    }

    $scope.logout = function(loc) {
      $rootScope.$storage.token_ = null;
      $rootScope.userdata = {
        firstname : "",
        lastname : "",
        display : "",
        img_src : "",
        logged : '{ "display" : "none" }',
        dim_avatar : '{"width" : "16px", "height" : "16px", "vertical-align" : "middle"}'
      };

      $http.get( "../wordpress/wp-logout" )
        .success(function(data, status, header, config) {
      })
        .error(function(data, status, header, config) {

        $http.get( "oauth/client.php?action=logout" )
          .success(function(data, status, header, config) {

          if(loc == "home") { setTimeout("location.reload();", 500);  }
          else { location.href = '#/home'; }
        })
          .error(function(data, status, header, config) {
          console.log("Error in $http.get() of ModalDemoCtrl (logout)");
        });

      });
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
