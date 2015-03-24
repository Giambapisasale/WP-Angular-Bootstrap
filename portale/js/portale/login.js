(function () {
  var app = angular.module('portale');

  app.controller('ModalDemoCtrl', function ($scope, $modal, $rootScope, $http, $interval) {
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

    $scope.call_status = false;
    $scope.open = function (size) {
      $scope.call_status = true;
      var modalInstance = $modal.open({
        template: '<iframe class="login_ifr" src="oauth/client.php?action=request_token"></iframe>' 
        + '<div class=""><progressbar value="percent" type="info">{{percent}}%</progressbar></div>',
        controller: 'ModalInstanceCtrl',
        size: size
      });

      modalInstance.result.then(function () {
      }, function () {
        $scope.call_status = false;
      });

      var status_update = function() {
        $http.get( "oauth/client.php?action=status", {cache:false} )
          .success(function(data, status, header, config) {
          console.log(data);
          if(data.percentage) {
            $rootScope.percent = data.percentage;
            if($scope.call_status == true && data.percentage < 100) {
              window.setTimeout(status_update, 1000);
            }
          }

        })
          .error(function(data, status, header, config) {
          console.log("Error in $http.get() of ModalDemoCtrl (status)");
        });
      }
      console.log("launch status update");
      window.setTimeout(status_update, 1000); 

      //      var req_status = $interval(function() {
      //        $http.get( "oauth/client.php?action=status" )
      //        .success(function(data, status, header, config) {
      //          $rootScope.percent = data.percentage;
      //          if($rootScope.percent == 100) { $scope.killstatus(); }
      //        })
      //        .error(function(data, status, header, config) {
      //          console.log("Error in $http.get() of ModalDemoCtrl (status)");
      //        });
      //      }, 1000);
      //
      //      $scope.killstatus = function() {
      //        if(angular.isDefined(req_status))
      //        {
      //          $interval.cancel(req_status);
      //          req_status = undefined;
      //        }
      //      };

    };
  });

  app.controller('ModalInstanceCtrl', function ($scope, $rootScope) {
    $rootScope.percent = '';
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
