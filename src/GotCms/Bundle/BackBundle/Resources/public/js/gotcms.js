(function() {
    'use strict';

    angular.module('gotcms', [
        /* angular modules */
        'ngAnimate',
        'ngCookies',

        /* third-party modules */
        'ui.router',
        'pascalprecht.translate',

        /* gotcms modules */
        'gotcms.core',
        'gotcms.api',
        'gotcms.dashboard',
        'gotcms.utils'
    ])
})();
