<?php

namespace BlogBundle\Tests\Controller;

use BlogBundle\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    private $articlePartialFixture = array(
        'title' => 't-fdasfbkadsf-gdfgh345jhf',
        'slug' => 's--vxcbdfg-ghfghdg-fdasfbkadsf-gdfgh345jhf',
        'content' => 't-fdasfbkadsf-gdfgh345jhfbhfg-ghdfgfh',
        'published' => true
    );

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        // Clean tables (just to prevent manually made changes to database file)

        $this->em->createQuery('DELETE FROM BlogBundle:Article a')->execute();

        // Add fixture entities to database

        $newArticleFixture = new Article();
        $newArticleFixture->setSlug($this->articlePartialFixture['slug']);
        $newArticleFixture->setTitle($this->articlePartialFixture['title']);
        $newArticleFixture->setContent($this->articlePartialFixture['content']);
        $newArticleFixture->setUpdatedOn(null);
        $newArticleFixture->setCreatedOn(new \DateTime());
        $newArticleFixture->setPublished($this->articlePartialFixture['published']);

        $this->em->persist($newArticleFixture);
        $this->em->flush();
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        // Clean tables

        $this->em->createQuery('DELETE FROM BlogBundle:Article a')->execute();
    }

    /**
     * Test articles list route
     */
    public function testGetArticlesActionWithoutFiltersAndCorrectRequestData()
    {
        // Get entities list

        $client = static::createClient();
        $client->request('GET', '/api/v0.1/articles',
            array()
        );

        $response = json_decode($client->getResponse()->getContent(), true);

        // Check if response is correct

        $this->assertEquals('ok', $response['status']['result']);
        $this->assertEquals('', $response['status']['description']);
        $this->assertEquals(1, count($response['data']));

        $articleFromResponse = $response['data'][0];

        $this->assertEquals($this->articlePartialFixture['title'], $articleFromResponse['title']);
        $this->assertEquals($this->articlePartialFixture['slug'], $articleFromResponse['slug']);
        $this->assertEquals($this->articlePartialFixture['content'], $articleFromResponse['content']);
        $this->assertEquals($this->articlePartialFixture['published'], $articleFromResponse['published']);
    }

    /**
     * Test article creation route
     */
    public function testPostArticlesActionWithCorrectRequestData()
    {
        // Prepare another article fixture

        $articlePartialFixture = $this->articlePartialFixture;
        $articlePartialFixture['slug'] .= '21sdf';

        // Execute creation query

        $client = static::createClient();
        $client->request('POST', '/api/v0.1/articles',
            array('article' => json_encode($articlePartialFixture))
        );

        $response = json_decode($client->getResponse()->getContent(), true);

        // Check if response is correct

        $this->assertEquals('ok', $response['status']['result']);
        $this->assertEquals('', $response['status']['description']);

        /* @var Article */
        $article = $this->em->getRepository('BlogBundle:Article')->findOneBySlug($articlePartialFixture['slug']);

        $this->assertNotNull($article);
        $this->assertEquals($articlePartialFixture['title'], $article->getTitle());
        $this->assertEquals($articlePartialFixture['slug'], $article->getSlug());
        $this->assertEquals($articlePartialFixture['content'], $article->getContent());
        $this->assertEquals($articlePartialFixture['published'], $article->getPublished());
    }

    /**
     * Test get article by slug
     */
    public function testGetArticleActionWithCorrectRequestData()
    {
        // Get entity

        $client = static::createClient();
        $client->request('GET', '/api/v0.1/articles/' . $this->articlePartialFixture['slug']);

        $response = json_decode($client->getResponse()->getContent(), true);

        // Check if response is correct

        $this->assertEquals('ok', $response['status']['result']);
        $this->assertEquals('', $response['status']['description']);
        $this->assertNotEmpty($response['data']);

        // Check if entity data is correct

        $articleFromResponse = $response['data'];

        $this->assertEquals($this->articlePartialFixture['title'], $articleFromResponse['title']);
        $this->assertEquals($this->articlePartialFixture['slug'], $articleFromResponse['slug']);
        $this->assertEquals($this->articlePartialFixture['content'], $articleFromResponse['content']);
        $this->assertEquals($this->articlePartialFixture['published'], $articleFromResponse['published']);
    }

    /**
     * Test article update route
     */
    public function testPutArticlesActionWithCorrectRequestData()
    {
        // Prepare updated article fixture

        $updatedArticlePartialFixture = $this->articlePartialFixture;
        $updatedArticlePartialFixture['title'] .= '21sdf';
        $updatedArticlePartialFixture['slug'] .= '21sdf';
        $updatedArticlePartialFixture['content'] .= '21sdf';
        $updatedArticlePartialFixture['published'] = false;

        // Execute update query

        $client = static::createClient();
        $client->request('PUT', '/api/v0.1/articles/' . $this->articlePartialFixture['slug'],
            array('article' => json_encode($updatedArticlePartialFixture))
        );

        $response = json_decode($client->getResponse()->getContent(), true);

        // Check if response is correct

        $this->assertEquals('ok', $response['status']['result']);
        $this->assertEquals('', $response['status']['description']);

        /* @var Article */
        $article = $this->em->getRepository('BlogBundle:Article')->findOneBySlug($updatedArticlePartialFixture['slug']);

        $this->assertNotNull($article);
        $this->assertEquals($updatedArticlePartialFixture['title'], $article->getTitle());
        $this->assertEquals($updatedArticlePartialFixture['slug'], $article->getSlug());
        $this->assertEquals($updatedArticlePartialFixture['content'], $article->getContent());
        $this->assertEquals($updatedArticlePartialFixture['published'], $article->getPublished());
    }

    /**
     * Test articles delete route
     */
    public function testDeleteArticleActionWithCorrectRequestData()
    {
        // Execute delete query

        $client = static::createClient();
        $client->request('DELETE', '/api/v0.1/articles/' . $this->articlePartialFixture['slug']);

        $response = json_decode($client->getResponse()->getContent(), true);

        // Check if response is correct

        $this->assertEquals('ok', $response['status']['result']);
        $this->assertEquals('', $response['status']['description']);

        // Check if entity was deleted

        $article = $this->em->getRepository('BlogBundle:Article')->findOneBySlug($this->articlePartialFixture['slug']);

        $this->assertNull($article);
    }
}