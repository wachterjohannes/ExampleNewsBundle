<?php

namespace Example\NewsBundle\Controller;

use Example\NewsBundle\News\NewsManager;
use Sulu\Component\Rest\RestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends RestController
{
    /**
     * Returns news-item by id.
     *
     * @param int $id
     *
     * @return Response
     */
    public function getNewsAction($id)
    {
        return $this->handleView(
            $this->view(
                $this->getManager()->read($id)
            )
        );
    }

    /**
     * Create a new news-item and returns it.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function postNewsAction(Request $request)
    {
        return $this->handleView(
            $this->view(
                $this->getManager()->create($request->request->all())
            )
        );
    }

    /**
     * Update a news-item with given id and returns it.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function putNewsAction($id, Request $request)
    {
        return $this->handleView(
            $this->view(
                $this->getManager()->update($id, $request->request->all())
            )
        );
    }

    /**
     * Returns service for news-items.
     *
     * @return NewsManager
     */
    private function getManager()
    {
        return $this->get('example_news.manager');
    }
}
