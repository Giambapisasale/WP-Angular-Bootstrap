/*jslint nomen: true, devel: true, browser: true, white: true, plusplus: true, eqeq: true, es5: true, forin: true */
/*global angular, console, alert*/

(function () {
  'use strict';
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

    if ($rootScope.$storage.token_ != null)
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

          if (loc == "home") { setTimeout(function() {
            location.reload();
          },
                                         500);  }
          else { location.href = '#/home'; }
        })
          .error(function(data, status, header, config) {
          console.log("Error in $http.get() of ModalDemoCtrl (logout)");
        });

      });
    };

    $http.get( "oauth/client.php?action=isLogged" )
      .success(function(data, status, header, config) {

      if ((data.indexOf("Yes") < 0) && $rootScope.$storage.token_ != null)
      {
        $scope.logout("home");
      }
    })
      .error(function(data, status, header, config) {
    });

    $scope.call_status = false;
    $scope.open = function (size) {
      var modalInstance, status_update;

      $scope.call_status = true;
      modalInstance = $modal.open({
        template: '<iframe class="login_ifr" src="oauth/client.php?action=request_token"></iframe>' 
        + '<div class=""><progressbar value="percent" type="info">{{percent}}%</progressbar></div>',
        controller: 'ModalInstanceCtrl',
        size: size
      });

      modalInstance.result.then(function () {
      }, function () {
        $scope.call_status = false;
      });

      status_update = function() {
        $http.get( "oauth/client.php?action=status", {cache:false} )
          .success(function(data, status, header, config) {
          if (data.percentage) {
            $rootScope.percent = data.percentage;
            if ($scope.call_status == true && data.percentage < 100) {
              window.setTimeout(status_update, 1000);
            }
          }

        })
          .error(function(data, status, header, config) {
          console.log("Error in $http.get() of ModalDemoCtrl (status)");
        });
      };
      console.log("launch status update");
      window.setTimeout(status_update, 1000);

    };
  });

  app.controller('ModalInstanceCtrl', function ($scope, $rootScope) {
    $rootScope.percent = '';
  });

  app.controller('StorageCtrl', function($scope, $localStorage, $rootScope) {
    $rootScope.$storage = $localStorage.$default({
      token: $scope.tokens
    });
  });
}());


function close_modal() {
  'use strict';
  document.getElementsByClassName('modal')[0].click();
}

function update_storage(data) {
  'use strict';
  var scope = angular.element(document.getElementById("storage")).scope();
  scope.$storage.token_ = JSON.parse(data);
  //alert(scope.$storage.token_);
  close_modal();
  location.href = '../#/panel/';
}
