<?php

namespace AppBundle\Controller\Frontend;

use AppBundle\Entity\Work;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route("/works/{page}", name="app_work_list", options={"i18n_prefix" = "secure"}, defaults={"page" = 1})
     * @Method({"GET"})
     *
     * @param int $page
     * @return Response
     */
    public function workListAction($page)
    {
        $paginator = $this->get('knp_paginator');
        $works = $paginator->paginate(
            $this->getDoctrine()->getRepository('AppBundle:Work')->findAllEnabledSortedByDate(),
            $page,
            9
        );

        return $this->render(
            ':Frontend/Work:index.html.twig',
            [ 'works' => $works ]
        );
    }

    /**
     * @Route("/work/{slug}", name="app_work_detail", options={"i18n_prefix" = "secure"})
     * @Method({"GET"})
     * @param $slug
     *
     * @return Response
     */
    public function workDetailAction($slug)
    {
        $work = $this->getDoctrine()->getRepository('AppBundle:Work')->findOneBy(['slug' => $slug]);

        if ($work->getEnabled() == false && !$this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')) {
            throw $this->createAccessDeniedException();
        }

        return $this->render(
            ':Frontend/Work:show.html.twig',
            [ 'work' => $work ]
        );
    }

    /**
     * @Route("/work/{slug}/next", name="app_work_detail_next", options={"i18n_prefix" = "secure"})
     * @Method({"GET"})
     * @param $slug
     *
     * @return Response
     */
    public function nextWorkAction($slug)
    {
        $works = $this->getDoctrine()->getRepository('AppBundle:Work')->findAllEnabledSortedByDate();
        $work = $this->getDoctrine()->getRepository('AppBundle:Work')->findOneBy(['slug' => $slug]);
        /** @var Work $item */
        foreach ($works as $i => $item) {
            if ($item->getSlug() == $work->getSlug()) {
                if (($i + 1) === count($works)) {
                    $work = $works[0];
                } else {
                    $work = $works[$i + 1];
                }
                break;
            }
        }

        return $this->redirectToRoute('app_work_detail', ['slug' => $work->getSlug()]);
    }

    /**
     * @Route("/work/{slug}/prev", name="app_work_detail_prev")
     * @Method({"GET"})
     * @param $slug
     *
     * @return Response
     */
    public function prevWorkAction($slug)
    {
        $works = $this->getDoctrine()->getRepository('AppBundle:Work')->findAllEnabledSortedByDate();
        $work = $this->getDoctrine()->getRepository('AppBundle:Work')->findOneBy(['slug' => $slug]);
        /** @var Work $item */
        foreach ($works as $i => $item) {
            if ($item->getSlug() == $work->getSlug()) {
                if ($i === 0) {
                    $work = $works[(count($works) - 1)];
                } else {
                    $work = $works[$i - 1];
                }
                break;
            }
        }

        return $this->redirectToRoute('app_work_detail', ['slug' => $work->getSlug()]);
    }
}
