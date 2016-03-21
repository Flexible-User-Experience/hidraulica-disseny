<?php

namespace AppBundle\Controller\Frontend;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class WorkController
 *
 * @category Controller
 * @package  AppBundle\Controller\Frontend
 * @author   Anton Serra <aserratorta@gmail.com>
 *
 */
class WorkController extends Controller
{
    /**
     * @Route("/works/", name="app_work_list", options={"i18n_prefix" = "secure"})
     */
    public function workListAction()
    {
        return $this->render(':Frontend/Work:index.html.twig');
    }

    /**
     * @Route("/work/{slug}/", name="app_work_detail", options={"i18n_prefix" = "secure"})
     * @param $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function workDetailAction($slug)
    {
        return $this->render(':Frontend/Work:show.html.twig');
    }
}
