<?php

namespace BlogBundle\Controller;

use BlogBundle\Entity\Article;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcherInterface;
use FOS\RestBundle\Controller\Annotations\QueryParam;
use FOS\RestBundle\Controller\Annotations\RequestParam;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
     * @ApiDoc()
     */
    public function getArticlesAction(ParamFetcherInterface $paramFetcher)
    {
        // Query parameters are NOT implemented!
        // Function which uses query parameters must be implemented in repository class.

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
     * @RequestParam(name="article", description="JSON stringified partial Article entity.")
     * @ApiDoc()
     */
    public function postArticlesAction(ParamFetcherInterface $paramFetcher)
    {
        $articlePartialObject = json_decode($paramFetcher->get('article'), true);

        $article = new Article();
        $article->setSlug($articlePartialObject['slug']);
        $article->setTitle($articlePartialObject['title']);
        $article->setContent($articlePartialObject['content']);
        $article->setUpdatedOn(new \DateTime());
        $article->setCreatedOn(new \DateTime());
        $article->setPublished($articlePartialObject['published']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($article);
        $em->flush();

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
     * @RequestParam(name="article", description="JSON stringified Article entity.")
     * @ApiDoc()
     */
    public function putArticleAction($slug, ParamFetcherInterface $paramFetcher)
    {
        $em = $this->getDoctrine()->getManager();

        // Check if article if requested slug exists

        $article = $em->getRepository('BlogBundle:Article')
            ->findOneBySlug($slug)
        ;

        if (!$article) {
            return $this->get('blog.response_generator')
                ->generateResponse('fail', 'Article was not found', $article)
            ;
        }

        // Update article

        $articlePartialObject = json_decode($paramFetcher->get('article'), true);

        $article->setSlug($articlePartialObject['slug']);
        $article->setTitle($articlePartialObject['title']);
        $article->setContent($articlePartialObject['content']);
        $article->setUpdatedOn(new \DateTime());
        $article->setPublished($articlePartialObject['published']);

        $em->flush();

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
        $em = $this->getDoctrine()->getManager();
        $em->createQuery('DELETE FROM BlogBundle:Article a WHERE a.slug = :slug')
            ->setParameter('slug', $slug)
            ->execute();
        ;

        return $this->get('blog.response_generator')
            ->generateResponse('ok')
        ;
    }
}
