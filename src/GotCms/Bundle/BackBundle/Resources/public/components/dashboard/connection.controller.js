(function() {
    'use strict';

    angular
        .module('gotcms.dashboard')
        .controller('ConnectionController', ConnectionController);

    /** @ngInject */
    function ConnectionController($log, $window, API, $location) {
        var vm = this;
        vm.userLogin       = userLogin;
        vm.isAuthenticated = isAuthenticated;


        function userLogin() {
            API.authenticate(vm.login, vm.password).then(function(response) {
                if (response.data.errors) {
                    vm.dataLoading = false;
                } else {
                    $location.path('/');
                }
            });
        }

        function isAuthenticated() {
            return API.isAuthenticated();
        }
    }
})();
