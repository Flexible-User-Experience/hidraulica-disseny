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
     * @Route("/works/", name="app_work_list")
     */
    public function workListAction()
    {
        return $this->render('Frontend/Work/work.html.twig');
    }

    /**
     * @Route("/work/{slug}/", name="app_work_detail")
     * @param $slug
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function workDetailAction($slug)
    {
        return $this->render('Frontend/Work/work_detail.html.twig');
    }
}
