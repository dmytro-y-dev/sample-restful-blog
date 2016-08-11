<?php

namespace BlogBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations\QueryParam;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class ArticleController extends FOSRestController
{
    /**
     * Get articles list.
     *
     * Query parameters:
     *   [Optional] offset (default = 0): Get articles starting from {offset}
     *   [Optional] limit (default = 0): Get not more than {limit} articles
     *   [Optional] sort-field (default = created_on): By what field to sort articles. Possible values are 'title', 'created_on', 'updated_on'.
     *   [Optional] sort-order (default = asc): Sort order. Possible values are 'asc', 'desc'.
     *   [Optional] only-published (default = true): If true, return only published articles. If false, return all articles. Works only when user has Admin role.
     *
     * @return JSON stringified array with articles
     */
    public function getArticlesAction()
    {
        //return new JsonResponse([1,2]);
    }

    /**
     * Create new article.
     *
     * Query parameters:
     *   article: JSON stringified Article entity.
     *
     * @return JSON stringified object with request result.
     */
    public function postArticlesAction()
    {
        //
    }

    /**
     * Get article by slug.
     *
     * @param $slug string Article's slug.
     *
     * @return JSON stringified Article object.
     */
    public function getArticleAction($slug)
    {
        //
    }

    /**
     * Update article by slug.
     *
     * Query parameters:
     *   article: JSON stringified Article entity.
     *
     * @param $slug string Article's slug.
     *
     * @return JSON stringified object with request result.
     */
    public function putArticleAction($slug)
    {
        //
    }

    /**
     * Delete article by slug.
     *
     * @param $slug string Article's slug.
     *
     * @return JSON stringified object with request result.
     */
    public function deleteArticleAction($slug)
    {
        //
    }
}
