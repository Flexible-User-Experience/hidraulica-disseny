<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Cart\Cart;
use AppBundle\Entity\Cart\Customer;
use AppBundle\Entity\Cart\Payment;
use AppBundle\Enum\CartStatusEnum;
use AppBundle\Form\Type\Step2CartFormType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Payum\Core\Request\GetHumanStatus;

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
     * @Route("/cart/top-menu-resume", name="app_cart_top_menu_resume")
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
     * @Route("/cart/include-new-item", name="app_cart_include_new_item")
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
     * @Route("/cart/new/item/{itemId}/", name="app_cart_new_item")
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
     * @Route("/cart/remove/item/{itemId}/", name="app_cart_remove_item")
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
     * @Route("/cart/list", name="app_cart_list_step_1")
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
     * @Route("/cart/checkout/", name="app_cart_checkout_step_2")
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
     * @Route("/cart/payment/", name="app_cart_payment_step_3")
     * @return Response
     */
    public function step3Action()
    {
        $cart = $this->getCart();
        $gatewayName = 'paypal';
        $storage = $this->get('payum')->getStorage('AppBundle\Entity\Cart\Payment');

        /** @var Payment $payment */
        $payment = $storage->create();
        $payment->setCart($cart);
        $payment->setNumber(uniqid());
        $payment->setCurrencyCode('EUR');
        $payment->setTotalAmount($cart->getTotalAmountWithDeliveryAndVatTax() * 100);
        $payment->setDescription('CART_ID#'. $cart->getId() . ' ' . $cart->getCreatedAt()->format('d/m/Y') . ' ' . $cart->getCustomer()->getName());
        $payment->setClientId($cart->getCustomer()->getId());
        $payment->setClientEmail($cart->getCustomer()->getEmail());
        $storage->update($payment);
        $cart->setStatus(CartStatusEnum::CART_STATUS_SENT);
        $em = $this->getDoctrine()->getManager();
        $em->flush();
        $this->get('app.cart_service')->removeSessionCart();

        $captureToken = $this->get('payum')->getTokenFactory()->createCaptureToken(
            $gatewayName,
            $payment,
            'app_cart_payment_done' // the route to redirect after capture
        );

        return $this->redirect($captureToken->getTargetUrl());
    }

    /**
     * @Route("/cart/payment/done", name="app_cart_payment_done")
     * @param Request $request
     *
     * @return Response
     */
    public function doneAction(Request $request)
    {
        $token = $this->get('payum')->getHttpRequestVerifier()->verify($request);
        $gateway = $this->get('payum')->getGateway($token->getGatewayName());

        // you can invalidate the token. The url could not be requested any more.
        // $this->get('payum')->getHttpRequestVerifier()->invalidate($token);

        // Once you have token you can get the model from the storage directly.
        //$identity = $token->getDetails();
        //$payment = $payum->getStorage($identity->getClass())->find($identity);

        // or Payum can fetch the model for you while executing a request (Preferred).
        $gateway->execute($status = new GetHumanStatus($token));
        /** @var Payment $payment */
        $payment = $status->getFirstModel();

        $cart = $payment->getCart();
        $cart->setStatus(CartStatusEnum::CART_STATUS_INVOICED);
        $em = $this->getDoctrine()->getManager();
        $em->persist($cart);
        $em->flush();

        // you have order and payment status
        // so you can do whatever you want for example you can just print status and payment details.

        return new JsonResponse(array(
            'status' => $status->getValue(),
            'payment' => array(
                'total_amount' => $payment->getTotalAmount(),
                'currency_code' => $payment->getCurrencyCode(),
                'details' => $payment->getDetails(),
            ),
        ));
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
