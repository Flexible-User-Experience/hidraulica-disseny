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
 *
 */
class ProductController extends Controller
{
    /**
     * @Route("/products/", name="app_product_list")
     */
    public function productListAction()
    {
        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findAll();

        return $this->render('Frontend/Product/product.html.twig', array(
            'products' => $products,
        ));
    }

    /**
     * @Route("/product/{slug}/", name="app_product_detail")
     * @param $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productDetailAction($slug)
    {
        return $this->render('Frontend/Product/product_detail.html.twig');
    }
}
