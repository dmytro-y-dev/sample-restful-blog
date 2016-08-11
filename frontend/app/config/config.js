'use strict';

angular.module('blog.config', [])
.factory('blogConfig', function() {
    var config = {
        'apiURL' : 'http://localhost/simple-blog-task/backend/web/app_dev.php/api/v0.1',
    };

    return config;
});