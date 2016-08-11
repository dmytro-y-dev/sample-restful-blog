<?php

namespace BlogBundle\Controller;

use FOS\RestBundle\Controller\FOSRestController;

class TagController extends FOSRestController
{
    /**
     * Get tags list.
     *
     * @return JSON stringified array with tags
     */
    public function getTagsAction()
    {
        //
    }

    /**
     * Create new tag.
     *
     * Query parameters:
     *   tag: JSON stringified Tag entity.
     *
     * @return JSON stringified object with request result.
     */
    public function postTagsAction()
    {
        //
    }

    /**
     * Get tag by slug.
     *
     * @param $slug string Tag's slug.
     *
     * @return JSON stringified Tag object.
     */
    public function getTagAction($slug)
    {
        //
    }

    /**
     * Update tag by slug.
     *
     * Query parameters:
     *   tag: JSON stringified Tag entity.
     *
     * @param $slug string Tag's slug.
     *
     * @return JSON stringified object with request result.
     */
    public function putTagAction($slug)
    {
        //
    }

    /**
     * Delete tag by slug.
     *
     * @param $slug string Tag's slug.
     *
     * @return JSON stringified object with request result.
     */
    public function deleteTagAction($slug)
    {
        //
    }
}
