(function() {
    'use strict';

    angular
        .module('gotcms.api')
        .factory('API', APIFactory);

    /** @ngInject */
    function APIFactory($log, $http) {
        var API = {};

        API.user     = {};

        API.authenticate        = authenticate;
        API.isAuthenticated     = isAuthenticated;
        API.logOut              = logOut;
        API.register            = register;

        return API;

        function authenticate(login, password) {
            return $http
                .post('/api/user/login', {
                    "login": login,
                    "password": password
                })
                .then(function(response) {
                    $log.debug('APIFactory.authenticate', response);
                    if (!response.data.errors) {
                        API.user = response.data;
                    }

                    return response;
                })
                .catch(function(error) {
                    $log.error('APIFactory.authenticate', error);
                    return error;
                });
        }

        function register(name, login, email, password) {
            return $http
                .post('/api/users', {
                    "name": name,
                    "login": login,
                    "password": password,
                    "email": email
                })
                .then(function(response) {
                    $log.debug('APIFactory.register', response);
                    return response;
                })
                .catch(function(error) {
                    $log.error('APIFactory.register', error);
                    return error;
                });
        }

        function logOut() {
            return $http
                .get('/api/user/logout')
                .then(function(response) {
                    $log.debug('APIFactory.logOut', response);
                    return response;
                })
                .catch(function(error) {
                    $log.error('APIFactory.logOut', error);
                    return error;
                });
        }

        function isAuthenticated() {
            return !angular.equals(API.user, {});
        }
    }
})();
