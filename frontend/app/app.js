'use strict';

// Declare app level module which depends on views, and components
angular.module('blog', [
  'ngRoute',
  'blog.admin.articles.editor',
  'blog.admin.articles.list'
]).
config(['$locationProvider', '$routeProvider', function($locationProvider, $routeProvider) {
  $locationProvider.hashPrefix('!');

  $routeProvider.otherwise({redirectTo: '/admin/list/articles'});
}]);
