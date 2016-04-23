<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Cart\Cart;
use AppBundle\Entity\Cart\Customer;
use AppBundle\Enum\CartStatusEnum;
use AppBundle\Form\Type\Step2CartFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class CartController
 *
 * @category Controller
 * @package  ECVulco\AppBundle\Controller\Frontend
 * @author   David Romaní <david@flux.cat>
 */
class CartController extends Controller
{
    /**
     * @Route("/cart/top-menu-resume", name="app_cart_top_menu_resume", options={"i18n_prefix" = "secure"})
     * @Method({"GET"})
     */
    public function topMenuResumeCartAction()
    {
        return $this->render(
            ':Frontend/Cart:top_menu_resume.html.twig',
            [ 'cart' => $this->getCart() ]
        );
    }

    /**
     * @Route("/cart/include-new-item", name="app_cart_include_new_item", options={"i18n_prefix" = "secure"})
     * @param Request $request
     *
     * @return Response
     */
    public function includeNewItemAction(Request $request)
    {
        if ($request->isMethod('POST')) {
            $quantity = $request->request->get('quantity');
            $productId = $request->request->get('product');
            $this->get('app.cart_service')->addItem($productId, $quantity);

            return $this->redirectToRoute('app_cart_list_step_1');
        }

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/cart/new/item/{itemId}/", name="app_cart_new_item", options={"i18n_prefix" = "secure"})
     * @param Request $request
     * @param int     $itemId
     *
     * @return Response
     */
    public function addItemAction(Request $request, $itemId)
    {
        $this->get('app.cart_service')->addItem($itemId);

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/cart/remove/item/{itemId}/", name="app_cart_remove_item", options={"i18n_prefix" = "secure"})
     * @param Request $request
     * @param int     $itemId
     *
     * @return Response
     */
    public function deleteItemAction(Request $request, $itemId)
    {
        $this->get('app.cart_service')->removeItem($itemId);

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("/cart/list", name="app_cart_list_step_1", options={"i18n_prefix" = "secure"})
     * @return Response
     */
    public function listAction()
    {
        return $this->render(
            ':Frontend/Cart:order_list_step_1.html.twig',
            ['cart' => $this->getCart()]
        );
    }

    /**
     * @Route("/cart/checkout/", name="app_cart_checkout_step_2", options={"i18n_prefix" = "secure"})
     * @param Request $request
     *
     * @return Response
     */
    public function step2Action(Request $request)
    {
        $step2Form = $this->createForm(Step2CartFormType::class);
        $step2Form->handleRequest($request);

        if ($step2Form->isSubmitted() && $step2Form->isValid()) {
            /** @var Customer $searchedCustomer */
            $searchedCustomer = $step2Form->getData();
            $customer = $this->get('app.customer_service')->loadCustomerByEmail($searchedCustomer);
            $em = $this->getDoctrine()->getManager();
            $em->persist($customer);
            $em->flush();
            $cart = $this->getCart();
            if ($cart) {
                $cart
                    ->setStatus(CartStatusEnum::CART_STATUS_PENDING)
                    ->setCustomer($customer);
                $em->persist($cart);
                $em->flush();
            }

            return $this->redirectToRoute('app_cart_payment_step_3');
        }

        return $this->render(
            ':Frontend/Cart:order_list_step_2.html.twig',
            [
                'cart' => $this->getCart(),
                'form' => $step2Form->createView(),
            ]
        );
    }

    /**
     * @Route("/cart/payment/", name="app_cart_payment_step_3", options={"i18n_prefix" = "secure"})
     * @return Response
     */
    public function step3Action()
    {
        return $this->render(
            ':Frontend/Cart:order_list_step_3.html.twig',
            ['cart' => $this->getCart()]
        );
    }

    /**
     * @return Cart|null
     */
    private function getCart()
    {
        $cart = $this->get('app.cart_service')->getCart();

        return $cart;
    }
}
