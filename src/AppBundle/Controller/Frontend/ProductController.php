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
     * @Route("/products/", name="app_product_list", options={"i18n_prefix" = "secure"})
     */
    public function productListAction()
    {
        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findAll();

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
        return $this->render(
            ':Frontend/Product:show.html.twig'
        );
    }
}
