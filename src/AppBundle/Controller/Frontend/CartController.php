<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Cart\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * @Route("/pedido/nuevo/item/{itemId}/", name="app_frontend_cart_add_item")
     * @param int $itemId
     *
     * @return Response
     */
    public function addItemAction($itemId)
    {
        $this->get('app.cart_service')->addItem($itemId);

        return $this->redirect($this->getRequest()->headers->get('referer'));
    }

    /**
     * @Route("/api/cart/update-item/{itemId}/quantity/{quantity}/", name="api_cart_update_item_quantity", options={"expose"=true})
     * @param int $itemId
     * @param int $quantity
     *
     * @return JsonResponse
     */
    public function updateItemCartQuantityAction($itemId, $quantity)
    {
        $line = 0;
        $moneyFormatter = $this->get('tbbc_money.formatter.money_formatter');
        if ($quantity <= 0) {
            $this->get('app.cart_service')->removeItem($itemId);
        } else {
            $this->get('app.cart_service')->setItemQuantity($itemId, $quantity);
            $product = $this->get('app.cart_service')->getItemById($itemId);
            $cartItem = $this->get('app.cart_service')->getCart()->getCartItemByProduct($product);
            $line = $moneyFormatter->asFloat($cartItem->getQuantityMultiplicationPriceWithTax());
        }

        return new JsonResponse(
            array(
                'line'   => $line,
                'base'   => $moneyFormatter->asFloat($this->get('app.cart_service')->getCart()->getTotalAmount()),
                'tax'    => $moneyFormatter->asFloat($this->get('app.cart_service')->getCart()->getTotalBaseTax()),
                'total'  => $moneyFormatter->asFloat($this->get('app.cart_service')->getCart()->getTotalAmountWithTax()),
                'result' => 'OK',
            )
        );
    }

    /**
     * @Route("/pedido/elimina/item/{itemId}/", name="app_frontend_cart_remove_item")
     * @param int $itemId
     *
     * @return Response
     */
    public function deleteItemAction($itemId)
    {
        $this->get('app.cart_service')->removeItem($itemId);

        return $this->redirect($this->getRequest()->headers->get('referer'));
    }

    /**
     * @Route("/pedido/", name="app_frontend_cart_order_list", options={"expose"=true})
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
     * @Route("/pedido/facturacion/", name="app_frontend_cart_order_step_2", options={"expose"=false})
     * @param Request $request
     *
     * @return Response
     */
    public function step2Action(Request $request)
    {
        $step2Form = $this->createForm(Step2CartFormType::class);
        $step2Form->handleRequest($request);

        if ($step2Form->isSubmitted() && $step2Form->isValid()) {
            $os = $this->get('app.order_service');
            $site = $request->attributes->get('subdomain');
            /** @var Order $order */
            $order = $os->saveOrder($step2Form->getData()['billing'], $this->getCart(), $site);

            return $this->get('app.services.payment')->handlePayment($order);
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
     * @Route("/pedido/pago/", name="app_frontend_cart_order_step_3", options={"expose"=false})
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
