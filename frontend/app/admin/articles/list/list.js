'use strict';

angular.module('blog.admin.articles.list', ['ngRoute', 'blog.config'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/admin/list/articles', {
    templateUrl: 'admin/articles/list/list.html',
    controller: 'ListArticlesCtrl'
  });
}])
.controller('ListArticlesCtrl', ['$scope', '$http', '$location', 'blogConfig', function($scope, $http, $location, $blogConfig) {
  $scope.articles = {};

  $scope.getArticles = function() {
    $http({
      'method' : 'GET',
      'url' : $blogConfig.apiURL + '/articles'
    }).then(function(response) {
      if (response.data.status.result == 'ok') {
        $scope.articles = response.data.data;
      } else {
        console.error(response.data.status.description);
      }
    }, function(response) {
      console.log(response);
    });
  };

  $scope.editArticle = function(slug) {
    $location.path('/admin/edit/articles/' + slug);
  };

  $scope.deleteArticle = function(slug) {
    $http({
      'method' : 'DELETE',
      'url' : $blogConfig.apiURL + '/articles/' + slug
    }).then(function(response) {
      if (response.data.status.result == 'ok') {
        $scope.getArticles();
      } else {
        console.error(response.data.status.description);
      }
    }, function(response) {
      console.log(response);
    });
  };

  $scope.getArticles();
}]);