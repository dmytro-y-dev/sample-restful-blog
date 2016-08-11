'use strict';

angular.module('blog.admin.articles.editor', ['ngRoute', 'blog.config'])

.config(['$routeProvider', function($routeProvider) {
  $routeProvider.when('/admin/create/articles', {
    templateUrl: 'admin/articles/editor/editor.html',
    controller: 'CreateArticleCtrl'
  });
  $routeProvider.when('/admin/edit/articles/:slug', {
    templateUrl: 'admin/articles/editor/editor.html',
    controller: 'UpdateArticleCtrl'
  });
}])

.controller('CreateArticleCtrl', ['$scope', '$http', '$location', 'blogConfig', function($scope, $http, $location, $blogConfig) {
  $scope.articlePartialObject = {
    slug: '',
    title: '',
    content: '',
    published: false
  };
  $scope.mode = 'create';

  $scope.createArticle = function(articlePartialObject) {
    $http({
      'method' : 'POST',
      'url' : $blogConfig.apiURL + '/articles',
      'data' : { 'article' : JSON.stringify(articlePartialObject) }
    }).then(function(response) {
      if (response.data.status.result == 'ok') {
        $location.path('/admin/list/articles');
      }
    }, function(response) {
      console.log(response);
    });
  };
}])

.controller('UpdateArticleCtrl', [
  '$scope', '$http', '$location', 'blogConfig', '$routeParams',
  function($scope, $http, $location, $blogConfig, $routeParams) {
  $scope.articleInitialPartialObject = {};
  $scope.articlePartialObject = {};
  $scope.mode = 'edit';

  $scope.getArticle = function(slug) {
    $http({
      'method' : 'GET',
      'url' : $blogConfig.apiURL + '/articles/' + slug
    }).then(function(response) {
      if (response.data.status.result == 'ok') {
        $scope.articleInitialPartialObject = {
          slug: response.data.data.slug,
          title: response.data.data.title,
          content: response.data.data.content,
          published: response.data.data.published
        };

        $scope.articlePartialObject = _.clone($scope.articleInitialPartialObject);
      } else {
        console.error(response.data.status.description);
      }
    }, function(response) {
      console.log(response);
    });
  };

  /**
   * Update article on web server.
   *
   * @param articlePartialObject Article entity with partially filled fields
   */
  $scope.updateArticle = function(articlePartialObject) {
    $http({
      'method' : 'PUT',
      'url' : $blogConfig.apiURL + '/articles/' + $scope.articleInitialPartialObject.slug,
      'data' : { 'article' : JSON.stringify(articlePartialObject) }
    }).then(function(response) {
      if (response.data.status.result == 'ok') {
        $location.path('/admin/list/articles');
      }
    }, function(response) {
      console.log(response);
    });
  };

  $scope.getArticle($routeParams.slug);
}]);