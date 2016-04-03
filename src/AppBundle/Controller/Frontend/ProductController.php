<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class ProductController
 *
 * @category Controller
 * @package  AppBundle\Controller\Frontend
 * @author   Anton Serra <aserratorta@gmail.com>
 */
class ProductController extends Controller
{
    /**
     * @Route("/products/{page}/", name="app_product_list", options={"i18n_prefix" = "secure"})
     *
     * @param int $page
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productListAction($page = 1)
    {
        $paginator = $this->get('knp_paginator');
        $products = $paginator->paginate(
            $this->getDoctrine()->getRepository('AppBundle:Product')->findAllEnabledSortedByDate(),
            $page,
            9
        );

        return $this->render(
            ':Frontend/Product:index.html.twig',
            [ 'products' => $products ]
        );
    }

    /**
     * @Route("/product/{slug}/", name="app_product_detail", options={"i18n_prefix" = "secure"})
     * @param $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productDetailAction($slug)
    {
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->findOneBy(
            array(
                'slug' => $slug,
            )
        );

        if ($product->getEnabled() == false && !$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        return $this->render(
            ':Frontend/Product:show.html.twig',
            [ 'product' => $product ]
        );
    }
}
