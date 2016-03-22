<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class WebController
 *
 * @category Controller
 * @package  AppBundle\Controller\Frontend
 * @author   Anton Serra <aserratorta@gmail.com>
 *
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
     * @Route("/about/", name="app_about", options={"i18n_prefix" = "secure"})
     */
    public function aboutAction()
    {
        return $this->render(':Frontend:about.html.twig');
    }

    /**
     * @Route("/contact/", name="app_contact", options={"i18n_prefix" = "secure"})
     */
    public function contactAction()
    {
        return $this->render(':Frontend:contact.html.twig');
    }
}
