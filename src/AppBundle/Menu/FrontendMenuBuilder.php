<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;

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
     * @param FactoryInterface     $factory
     * @param AuthorizationChecker $ac
     */
    public function __construct(FactoryInterface $factory, AuthorizationChecker $ac)
    {
        $this->factory = $factory;
        $this->ac = $ac;
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return ItemInterface
     */
    public function createTopMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'my-menu list-unstyled no-gap-bottom');
        if ($this->ac->isGranted('ROLE_CMS')) {
            $menu->addChild(
                'admin',
                array(
                    'label' => 'front.menu.admin',
                    'route' => 'sonata_admin_dashboard',
                )
            );
        }
        $menu->addChild(
            'app_homepage',
            array(
                'label' => 'front.menu.homepage',
                'route' => 'app_homepage',
            )
        );
        $menu->addChild(
            'app_work_list',
            array(
                'label' => 'front.menu.work',
                'route' => 'app_work_list',
            )
        );
        $menu->addChild(
            'app_product_list',
            array(
                'label' => 'front.menu.shop',
                'route' => 'app_product_list',
            )
        );
        $menu->addChild(
            'app_about',
            array(
                'label' => 'front.menu.about',
                'route' => 'app_about',
            )
        );
        $menu->addChild(
            'app_contact',
            array(
                'label' => 'front.menu.contact',
                'route' => 'app_contact',
            )
        );

        return $menu;
    }
}
