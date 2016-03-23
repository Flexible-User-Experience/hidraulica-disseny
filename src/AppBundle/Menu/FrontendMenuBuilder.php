<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Translation\DataCollectorTranslator;

/**
 * Class FrontendMenuBuilder
 *
 * @category Menu
 * @package  AppBundle\Menu
 * @author   Anotn Serra <aserratorta@gmail.com>
 */
class FrontendMenuBuilder
{
    /**
     * @var FactoryInterface
     */
    private $factory;

    /**
     * @var AuthorizationChecker
     */
    private $ac;

    /**
     * @var DataCollectorTranslator
     */
    private $ts;

    /**
     * @param FactoryInterface        $factory
     * @param AuthorizationChecker    $ac
     * @param DataCollectorTranslator $ts
     */
    public function __construct(FactoryInterface $factory, AuthorizationChecker $ac, DataCollectorTranslator $ts)
    {
        $this->factory = $factory;
        $this->ac = $ac;
        $this->ts = $ts;
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return ItemInterface
     */
    public function createTopMenu(RequestStack $requestStack)
    {
        $route = $requestStack->getCurrentRequest()->get('_route');
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'nav navbar-nav navbar-right');
        if ($this->ac->isGranted('ROLE_CMS')) {
            $menu->addChild(
                'admin',
                array(
                    'label' => $this->ts->trans('front.menu.admin'),
                    'route' => 'sonata_admin_dashboard',
                )
            );
        }
        $menu->addChild(
            'app_homepage',
            array(
                'label' => $this->ts->trans('front.menu.homepage'),
                'route' => 'app_homepage',
            )
        );
        $menu->addChild(
            'app_work_list',
            array(
                'label'   => $this->ts->trans('front.menu.work'),
                'route'   => 'app_work_list',
                'current' => $route == 'app_work_list' || $route == 'app_work_detail',
            )
        );
        $menu->addChild(
            'app_product_list',
            array(
                'label'   => $this->ts->trans('front.menu.shop'),
                'route'   => 'app_product_list',
                'current' => $route == 'app_product_list' || $route == 'app_product_detail',
            )
        );
        $menu->addChild(
            'app_about',
            array(
                'label' => $this->ts->trans('front.menu.about'),
                'route' => 'app_about',
            )
        );
        $menu->addChild(
            'app_contact',
            array(
                'label' => $this->ts->trans('front.menu.contact'),
                'route' => 'app_contact',
            )
        );

        return $menu;
    }
}
