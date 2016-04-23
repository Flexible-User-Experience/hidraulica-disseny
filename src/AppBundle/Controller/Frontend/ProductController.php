<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route("/products/{page}", name="app_product_list", options={"i18n_prefix" = "secure"}, defaults={"page" = 1})
     * @Method({"GET"})
     *
     * @param int $page
     * @return Response
     */
    public function productListAction($page)
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
     * @Route("/product/{slug}", name="app_product_detail", options={"i18n_prefix" = "secure"})
     * @Method({"GET"})
     * @param $slug
     *
     * @return Response
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

        $quantity = 0;
        $cart = $this->get('app.cart_service')->getCart();
        if ($cart) {
            $cartItem = $cart->getCartItemByProduct($product);
            if ($cartItem) {
                $quantity = $cartItem->getQuantity();
            }
        }

        return $this->render(
            ':Frontend/Product:show.html.twig',
            [
                'product'  => $product,
                'quantity' => $quantity,
            ]
        );
    }

    /**
     * @Route("/product/{slug}/prev", name="app_product_detail_prev", options={"i18n_prefix" = "secure"})
     * @Method({"GET"})
     * @param $slug
     *
     * @return Response
     */
    public function prevProductAction($slug)
    {
        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findAllEnabledSortedByDate();
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->findOneBy(['slug' => $slug]);
        /** @var Product $item */
        foreach ($products as $i => $item) {
            if ($item->getSlug() == $product->getSlug()) {
                if ($i === 0) {
                    $product = $products[(count($products) - 1)];
                } else {
                    $product = $products[$i - 1];
                }
                break;
            }
        }

        return $this->redirectToRoute('app_product_detail', ['slug' => $product->getSlug()]);
    }

    /**
     * @Route("/product/{slug}/next", name="app_product_detail_next", options={"i18n_prefix" = "secure"})
     * @Method({"GET"})
     * @param $slug
     *
     * @return Response
     */
    public function nextProductAction($slug)
    {
        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findAllEnabledSortedByDate();
        $product = $this->getDoctrine()->getRepository('AppBundle:Product')->findOneBy(['slug' => $slug]);
        /** @var Product $item */
        foreach ($products as $i => $item) {
            if ($item->getSlug() == $product->getSlug()) {
                if (($i + 1) === count($products)) {
                    $product = $products[0];
                } else {
                    $product = $products[$i + 1];
                }
                break;
            }
        }

        return $this->redirectToRoute('app_product_detail', ['slug' => $product->getSlug()]);
    }
}
