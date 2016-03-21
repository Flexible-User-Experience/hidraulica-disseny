<?php

namespace AppBundle\Controller\Admin;

use AppBundle\Entity\Product;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ProductAdminController
 *
 * @category Controller
 * @package  AppBundle\Controller\Admin
 * @author   David Romaní <david@flux.cat>
 */
class ProductAdminController extends BaseAdminController
{
    /**
     * Preview action
     *
     * @param int|string|null $id
     * @param Request $request
     *
     * @return Response
     * @throws NotFoundHttpException If the object does not exist
     * @throws AccessDeniedException If access is not granted
     */
    public function previewAction($id = null, Request $request = null)
    {
        $request = $this->resolveRequest($request);
        $id = $request->get($this->admin->getIdParameter());

        /** @var Product $object */
        $object = $this->admin->getObject($id);

        if (!$object) {
            throw $this->createNotFoundException(sprintf('unable to find the object with id : %s', $id));
        }

        return $this->redirect($this->generateUrl('app_product_detail', array(
            'slug' => $object->getSlug(),
        )));
    }
}
