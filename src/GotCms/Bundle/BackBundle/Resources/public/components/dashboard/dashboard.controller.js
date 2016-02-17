(function() {
    'use strict';

    angular
        .module('gotcms.dashboard')
        .controller('DashboardController', DashboardController);

    /** @ngInject */
    function DashboardController($log, $window, API) {
        var vm = this;
        vm.isUserLogged = isUserLogged;
        vm.offset       = 0;
        vm.limit        = 2;

        function isUserLogged() {
            return API.isAuthenticated();
        }
    }
})();
