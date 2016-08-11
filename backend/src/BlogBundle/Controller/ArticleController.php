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
     * @param $paramFetcher ParamFetcherInterface Query parameters container.
     *
     * @return JSON stringified array with articles
     *
     * @QueryParam(name="offset", requirements="\d+", default="0", description="Get articles starting from {offset}.")
     * @QueryParam(name="limit", requirements="\d+", default="0", description="Get not more than {limit} articles.")
     * @QueryParam(name="sort_field", default="0", description="By what field to sort articles. Possible values are 'title', 'created_on', 'updated_on'.")
     * @QueryParam(name="sort_order", default="asc", description="Sort order. Possible values are 'asc', 'desc'.")
     * @QueryParam(name="only_published", default="true", description="If true, return only published articles. If false, return all articles. Works only when user has Admin role.")
     */
    public function getArticlesAction(ParamFetcherInterface $paramFetcher)
    {
        $articles = $this->getDoctrine()
            ->getRepository('BlogBundle:Article')
            ->findAll()
        ;

        return $this->get('blog.response_generator')
            ->generateResponse('ok', '', $articles)
        ;
    }

    /**
     * Create new article.
     *
     * @param $paramFetcher ParamFetcherInterface Query parameters container
     *
     * @return JSON stringified object with request result.
     *
     * @QueryParam(name="article", description="JSON stringified Article entity.")
     */
    public function postArticlesAction(ParamFetcherInterface $paramFetcher)
    {
        //$article =

        // TODO: Persist article

        return $this->get('blog.response_generator')
            ->generateResponse('ok')
        ;
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
        $article = $this->getDoctrine()
            ->getRepository('BlogBundle:Article')
            ->findOneBySlug($slug)
        ;

        if (!$article) {
            return $this->get('blog.response_generator')
                ->generateResponse('fail', 'Article was not found', $article)
            ;
        }

        return $this->get('blog.response_generator')
            ->generateResponse('ok', '', $article)
        ;
    }

    /**
     * Update article by slug.
     *
     * @param $slug string Article's slug.
     * @param $paramFetcher ParamFetcherInterface Query parameters container.
     *
     * @return JSON stringified object with request result.
     *
     * @QueryParam(name="article", description="JSON stringified Article entity.")
     */
    public function putArticleAction($slug, ParamFetcherInterface $paramFetcher)
    {
        $article = $this->getDoctrine()
            ->getRepository('BlogBundle:Article')
            ->findOneBySlug($slug)
        ;

        if (!$article) {
            return $this->get('blog.response_generator')
                ->generateResponse('fail', 'Article was not found', $article)
            ;
        }

        // TODO: Update article

        return $this->get('blog.response_generator')
            ->generateResponse('ok')
        ;
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
        $em = $this->getDoctrine();

        $article = $em->getReference('BlogBundle:Article', array('slug' => $slug));
        $em->remove($article);

        return $this->get('blog.response_generator')
            ->generateResponse('ok')
        ;
    }
}
