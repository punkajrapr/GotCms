(function() {
    'use strict';

    angular
        .module('gotcms.core')
        .config(routerConfig);

    /** @ngInject */
    function routerConfig($stateProvider, $urlRouterProvider) {
        /* redirect to '/' if no url match */
        $urlRouterProvider.otherwise('/');

        /* states declarations */
        $stateProvider
            .state('app', app())
            .state('app.dashboard', dashboard())
            .state('app.config', config())
            .state('app.content', content())
            .state('app.development', development())
            .state('app.module', module())
            .state('app.stats', stats())
            .state('app.login', login());

        /* states definitions */
        function app() {
            return {
                abstract: 'true',
                views: {
                    topbar: {
                        templateUrl: 'bundles/gotcmsback/components/utils/topbar.tpl.html',
                        controller: 'TopbarController as topbarCtrl'
                    }
                }// ,
                // resolve: {
                //     apiInit: apiInit
                // }
            }
        }

        /** @ngInject */
        function apiInit($window, $location, API) {
            // var sessionParams = $window.sessionStorage;
            // return API
            //     .authenticate(sessionParams)
            //     .then(function(response) {
            //         if(response.status === 403) {
            //             $window.sessionStorage.clear();
            //             $location.path('/');
            //         }
            //     });
        }

        function dashboard() {
            return {
                'url': '/',
                views: {
                    'content@': {
                        templateUrl: 'bundles/gotcmsback/components/dashboard/dashboard.tpl.html',
                        controller: 'DashboardController as dashboardCtrl'
                    }
                }
            }
        }

        function config() {
            return {
                'url': '/config',
                views: {
                    'content@': {
                        templateUrl: 'bundles/gotcmsback/components/config/config.tpl.html',
                        controller: 'ConfigController as configCtrl'
                    }
                }
            }
        }

        function development() {
            return {
                'url': '/development',
                views: {
                    'content@': {
                        templateUrl: 'bundles/gotcmsback/components/development/development.tpl.html',
                        controller: 'ContentController as developmentCtrl'
                    }
                }
            }
        }

        function module() {
            return {
                'url': '/module',
                views: {
                    'content@': {
                        templateUrl: 'bundles/gotcmsback/components/module/module.tpl.html',
                        controller: 'ModuleController as moduleCtrl'
                    }
                }
            }
        }

        function stats() {
            return {
                'url': '/stats',
                views: {
                    'content@': {
                        templateUrl: 'bundles/gotcmsback/components/stats/stats.tpl.html',
                        controller: 'StatsController as statsCtrl'
                    }
                }
            }
        }

        function content() {
            return {
                'url': '/content',
                views: {
                    'content@': {
                        templateUrl: 'bundles/gotcmsback/components/content/content.tpl.html',
                        controller: 'ContentController as contentCtrl'
                    }
                }
            }
        }

        function login() {
            return {
                'url': '/login',
                views: {
                    'content@': {
                        templateUrl: 'bundles/gotcmsback/components/dashboard/login.tpl.html',
                        controller: 'ConnectionController as connectionCtrl'
                    }
                }
            }
        }
    }
})();
