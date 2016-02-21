<?php

namespace AppBundle\Menu;

use AppBundle\Controller\WebController;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
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
     * @var EntityManager
     */
    private $em;

    /**
     * @var AuthorizationChecker
     */
    private $ac;

    /**
     * @var ArrayCollection all categories enabled sorted by title
     */
    private $categories;

    /**
     * @var ArrayCollection all static pages sorted by title
     */
    private $pages;

    /**
     * @param FactoryInterface     $factory
     * @param EntityManager        $em
     * @param AuthorizationChecker $ac
     */
    public function __construct(FactoryInterface $factory, EntityManager $em, AuthorizationChecker $ac)
    {
        $this->factory = $factory;
        $this->em = $em;
        $this->ac = $ac;
        $this->categories = $this->em->getRepository('AppBundle:Category')->findAllEnabledSortedByTitle();
        $this->pages = $this->em->getRepository('AppBundle:Page')->findAllSortedByTitle();
    }

    /**
     * @param RequestStack $requestStack
     *
     * @return ItemInterface
     */
    public function createSocialNetworksMenu(RequestStack $requestStack)
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'my-menu list-unstyled no-gap-bottom');
        $menu->setChildrenAttribute('style', 'overflow:hidden');
        $menu
            ->addChild(
                'facebook',
                array(
                    'label' => 'facebook',
                    'uri'   => 'https://www.facebook.com/asbelesteve',
                )
            );
        $menu
            ->addChild(
                'vimeo',
                array(
                    'label' => 'vimeo',
                    'uri'   => 'https://vimeo.com/asbelesteve',
                )
            );
        $menu
            ->addChild(
                'behance',
                array(
                    'label' => 'behance',
                    'uri'   => 'https://www.behance.net',
                )
            );
        $menu
            ->addChild(
                'pinterest',
                array(
                    'label' => 'pinterest',
                    'uri'   => 'https://www.pinterest.com',
                    )
            );

        return $menu;
    }
}
