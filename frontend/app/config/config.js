'use strict';

angular.module('blog.config', [])
.factory('blogConfig', function() {
    var config = {
        'apiURL' : 'http://localhost/sio_blog/backend/web/app_dev.php/api/v0.1',
    };

    return config;
});