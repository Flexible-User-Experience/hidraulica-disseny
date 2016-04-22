<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\ContactMessage;
use AppBundle\Entity\Work;
use AppBundle\Entity\Product;
use AppBundle\Form\Type\ContactMessageType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class WebController
 *
 * @category Controller
 * @package  AppBundle\Controller\Frontend
 * @author   Anton Serra <aserratorta@gmail.com>
 */
class WebController extends Controller
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function indexAction()
    {
        return $this->render(':Frontend:homepage.html.twig');
    }

    /**
     * @Route("/", name="app_secure_homepage", options={"i18n_prefix" = "secure"})
     */
    public function secureIndexAction()
    {
        $slides = $this->getDoctrine()->getRepository('AppBundle:SliderImage')->findAllEnabledSortedByPosition();
        $works = $this->getDoctrine()->getRepository('AppBundle:Work')->findShowInHomepageEnabledSortedByDate(9);
        $products = $this->getDoctrine()->getRepository('AppBundle:Product')->findShowInHomepageEnabledSortedByDate(9);
        $thumbs = array_merge($works, $products);
        usort(
            $thumbs,
            function ($a, $b) {
                /** @var Work|Product $a */
                /** @var Work|Product $b */
                if ($a->getCreatedAt() == $b->getCreatedAt()) {
                    return 0;
                }

                return ($a->getCreatedAt() > $b->getCreatedAt()) ? -1 : 1;
            }
        );

        return $this->render(
            ':Frontend:secure_homepage.html.twig',
            [
                'thumbs' => $thumbs,
                'slides' => $slides,
            ]
        );
    }

    /**
     * @Route("/about-us", name="app_about", options={"i18n_prefix" = "secure"})
     */
    public function aboutAction()
    {
        return $this->render(':Frontend:about.html.twig');
    }

    /**
     * @Route("/contact", name="app_contact", options={"i18n_prefix" = "secure"})
     * @param Request $request
     *
     * @return Response
     */
    public function contactAction(Request $request)
    {
        $contact = new ContactMessage();
        $form = $this->createForm(ContactMessageType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // persist entity
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            // send notifications
            $messenger = $this->get('app.notification');
            $messenger->sendUserNotification($contact);
            $messenger->sendAdminNotification($contact);
            // reset form
            $contact = new ContactMessage();
            $form = $this->createForm(ContactMessageType::class, $contact);
            // build flash message
            $this->addFlash('msg', 'front.form.flash.user');
        }

        return $this->render(
            ':Frontend:contact.html.twig',
            ['form' => $form->createView()]
        );
    }
}
