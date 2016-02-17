(function() {
    'use strict';

    angular
        .module('gotcms.utils')
        .controller('TopbarController', TopbarController);

    /** @ngInject */
    function TopbarController($log, $window, API) {
        var vm = this;
        vm.logOut       = logOut;
        vm.getUser      = getUser;

        function logOut() {
            API
                .logOut()
                .then(function() {
                    $window.sessionStorage.clear();
                    $window.location.reload();
                });
        }

        function getUser() {
            return API.user;
        }
    }
})();
