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
     * @Route("/product", name="product")
     */
    public function productListAction()
    {
        return $this->render('Frontend/Product/product.html.twig');
    }

    /**
     * @Route("/product/{slug}", name="product_detail")
     * @param $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function productDetailAction()
    {
        return $this->render('Frontend/Product/product_detail.html.twig');
    }
}
