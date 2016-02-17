(function() {
    'use strict';

    angular
        .module('gotcms.core')
        .config(config);

    /** @ngInject */
    function config($logProvider, $locationProvider) {
        $logProvider.debugEnabled(true);
        $locationProvider.html5Mode(true);
    }
})();
