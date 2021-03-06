<?php

namespace Example\NewsBundle\Controller;

use Example\NewsBundle\News\NewsManager;
use FOS\RestBundle\Controller\Annotations\Get;
use Sulu\Component\Rest\ListBuilder\Doctrine\FieldDescriptor\DoctrineFieldDescriptor;
use Sulu\Component\Rest\ListBuilder\ListRepresentation;
use Sulu\Component\Rest\RestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class NewsController extends RestController
{
    const ENTITY_NAME = 'ExampleNewsBundle:NewsItem';

    /**
     * Returns array of existing field-descriptors.
     *
     * @return array
     */
    private function getFieldDescriptors()
    {
        return [
            'id' => new DoctrineFieldDescriptor(
                'id',
                'id',
                self::ENTITY_NAME,
                'public.id',
                [],
                true
            ),
            'title' => new DoctrineFieldDescriptor(
                'title',
                'title',
                self::ENTITY_NAME,
                'public.title'
            ),
            'teaser' => new DoctrineFieldDescriptor(
                'teaser',
                'teaser',
                self::ENTITY_NAME,
                'news.teaser'
            )
        ];
    }

    /**
     * Returns all fields that can be used by list.
     *
     * @Get("news/fields")
     *
     * @return Response
     */
    public function getNewsFieldsAction()
    {
        return $this->handleView(
            $this->view(array_values($this->getFieldDescriptors()))
        );
    }

    /**
     * Shows all news-items
     *
     * @Get("news")
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getNewsListAction(Request $request)
    {
        $restHelper = $this->get('sulu_core.doctrine_rest_helper');

        $factory = $this->get('sulu_core.doctrine_list_builder_factory');

        $listBuilder = $factory->create(self::ENTITY_NAME);
        $restHelper->initializeListBuilder($listBuilder, $this->getFieldDescriptors());
        $results = $listBuilder->execute();

        $list = new ListRepresentation(
            $results,
            'news-items',
            'get_news_list',
            $request->query->all(),
            $listBuilder->getCurrentPage(),
            $listBuilder->getLimit(),
            $listBuilder->count()
        );

        $view = $this->view($list, 200);

        return $this->handleView($view);
    }

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
     * @param int $id
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
     * Delete a news-item with given id.
     *
     * @param int $id
     *
     * @return Response
     */
    public function deleteNewsAction($id)
    {
        $this->getManager()->delete($id);

        return $this->handleView($view = $this->view(null, 204));
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
