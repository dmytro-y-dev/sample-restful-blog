'use strict';

describe('blog.admin.articles.editor module', function() {
  beforeEach(module('blog.admin.articles.editor'));

  describe('CreateArticleCtrl controller', function(){
    it('should have properly initialized scope', inject(function($rootScope, $controller) {
      var scope = $rootScope.$new();
      var createArticleCtrl = $controller('CreateArticleCtrl', {$scope: scope});

      expect(createArticleCtrl).toBeDefined();

      expect(angular.equals('create', scope.mode)).toBe(true);
      expect(scope.articlePartialObject).toBeDefined();
      expect(scope.createArticle).toBeDefined();
    }));

    it('should have proper http request for article creating', inject(function($rootScope, blogConfig, $controller) {
      var scopeMock = $rootScope.$new();
      var httpMock = function(request) {
        expect(angular.equals(blogConfig.apiURL + '/articles', request.url)).toBe(true);
        expect(angular.equals('POST', request.method)).toBe(true);
        expect(request.data.article).toBeDefined();

        return { then: function(a, b) {} };
      };

      var createArticleCtrl = $controller('CreateArticleCtrl', {$scope: scopeMock, $http: httpMock});
      scopeMock.createArticle({'slug' : 'article-slug'});
    }));
  });

  describe('UpdateArticleCtrl controller', function(){
    var scopeMock, routeParams;

    beforeEach(inject(function($rootScope) {
      scopeMock = $rootScope.$new();
      routeParams = { 'slug' : 'slug-from-route-params' };
    }));

    it('should have properly initialized scope', inject(function($rootScope, $controller) {
      var updateArticleCtrl = $controller('UpdateArticleCtrl', {$scope: scopeMock, $routeParams: routeParams});

      expect(updateArticleCtrl).toBeDefined();

      expect(angular.equals('edit', scopeMock.mode)).toBe(true);
      expect(scopeMock.articlePartialObject).toBeDefined();
      expect(scopeMock.articleInitialPartialObject).toBeDefined();
      expect(scopeMock.getArticle).toBeDefined();
      expect(scopeMock.updateArticle).toBeDefined();
    }));

    it('should have proper http request for article fetching', inject(function($rootScope, blogConfig, $controller) {
      var httpMock = function(request) {
        // getArticle is called on controller initialization, so we must skip it.
        // To avoid this, consider moving HTTP requests to separate service.

        if (request.url.indexOf(routeParams.slug)) {
          return { then: function(a, b) {} };
        }

        // Let's check our request

        expect(angular.equals(blogConfig.apiURL + '/articles/article-slug', request.url)).toBe(true);
        expect(angular.equals('GET', request.method)).toBe(true);

        return { then: function(a, b) {} };
      };

      var updateArticleCtrl = $controller('UpdateArticleCtrl', {$scope: scopeMock, $http: httpMock, $routeParams: routeParams});
      scopeMock.getArticle('article-slug');
    }));

    it('should have proper http request for article update', inject(function($rootScope, blogConfig, $controller) {
      var httpMock = function(request) {
        // getArticle is called on controller initialization, so we must skip it.
        // To avoid this, consider moving HTTP requests to separate service.

        if (request.url.indexOf(routeParams.slug)) {
          return { then: function(a, b) {} };
        }

        // Let's check our request

        expect(angular.equals(blogConfig.apiURL + '/articles/article-slug', request.url)).toBe(true);
        expect(angular.equals('PUT', request.method)).toBe(true);
        expect(request.data.article).toBeDefined();

        return { then: function(a, b) {} };
      };

      var updateArticleCtrl = $controller('UpdateArticleCtrl', {$scope: scopeMock, $http: httpMock, $routeParams: routeParams});
      scopeMock.updateArticle({'slug' : 'article-slug'});
    }));
  });
});