(function() {
    'use strict';

    angular
        .module('gotcms.core')
        .run(authBlock);

    /** @ngInject */
    function authBlock($log, $window, $location) {
        var queryParams = $location.search();

        /* set query params into session storage and reload app */
        if(!angular.equals(queryParams, {})) {
            $log.debug(queryParams);
            angular.forEach(queryParams, function(value, key) {
                $window.sessionStorage.setItem(key, value);
            });
            $location.url('/');
        }
    }
})();
