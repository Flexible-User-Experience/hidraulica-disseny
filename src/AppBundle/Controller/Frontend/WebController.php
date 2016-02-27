<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class WebController extends Controller
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function indexAction()
    {
        return $this->render(':Frontend:homepage.html.twig');
    }
}
