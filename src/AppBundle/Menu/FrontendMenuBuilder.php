<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * Class FrontendMenuBuilder
 *
 * @category Menu
 * @package  AppBundle\Menu
 * @author   David Romaní <david@flux.cat>
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
     * @var TranslatorInterface
     */
    private $ts;

    /**
     * @var TokenStorageInterface
     */
    private $tss;

    /**
     * @param FactoryInterface      $factory
     * @param AuthorizationChecker  $ac
     * @param TranslatorInterface   $ts
     * @param TokenStorageInterface $tss
     */
    public function __construct(FactoryInterface $factory, AuthorizationChecker $ac, TranslatorInterface $ts, TokenStorageInterface $tss)
    {
        $this->factory = $factory;
        $this->ac = $ac;
        $this->ts = $ts;
        $this->tss = $tss;
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
        if ($this->tss->getToken() && $this->ac->isGranted('ROLE_CMS')) {
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
