<?php

namespace AppBundle\Listener;

use AppBundle\Repository\WorkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Presta\SitemapBundle\Service\SitemapListenerInterface;
use Presta\SitemapBundle\Event\SitemapPopulateEvent;
use Presta\SitemapBundle\Sitemap\Url\UrlConcrete;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

/**
 * Class SitemapListener
 *
 * @category Listener
 * @package  AppBundle\Listener
 * @author   David Romaní <david@flux.cat>
 */
class SitemapListener implements SitemapListenerInterface
{
    /** @var RouterInterface */
    private $router;

    /** @var EntityManager */
    private $em;

    /** @var WorkRepository */
    private $wr;

    /**
     * SitemapListener constructor
     *
     * @param RouterInterface $router
     * @param EntityManager   $em
     * @param WorkRepository  $wr
     */
    public function __construct(RouterInterface $router, EntityManager $em, WorkRepository $wr)
    {
        $this->router = $router;
        $this->em = $em;
        $this->wr = $wr;
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function populateSitemap(SitemapPopulateEvent $event)
    {
        $section = $event->getSection();
        if (is_null($section) || $section == 'default') {
            // Homepage
            $event
                ->getGenerator()
                ->addUrl(
                    new UrlConcrete(
                        $this->router->generate('app_homepage', array(), UrlGeneratorInterface::ABSOLUTE_URL),
                        new \DateTime(),
                        UrlConcrete::CHANGEFREQ_HOURLY,
                        1
                    ),
                    'default'
                );
            // About
            $event
                ->getGenerator()
                ->addUrl(
                    new UrlConcrete(
                        $this->router->generate('app_about', array(), UrlGeneratorInterface::ABSOLUTE_URL),
                        new \DateTime(),
                        UrlConcrete::CHANGEFREQ_HOURLY,
                        1
                    ),
                    'default'
                );
            // Contact
            $event
                ->getGenerator()
                ->addUrl(
                    new UrlConcrete(
                        $this->router->generate('app_contact', array(), UrlGeneratorInterface::ABSOLUTE_URL),
                        new \DateTime(),
                        UrlConcrete::CHANGEFREQ_HOURLY,
                        1
                    ),
                    'default'
                );

//            // Blog categories list
//            /** @var Category $category */
//            foreach ($this->categories as $category) {
//                $url = $this->router->generate(
//                    'category_detail',
//                    array(
//                        'slug' => $category->getSlug(),
//                    ),
//                    UrlGeneratorInterface::ABSOLUTE_URL
//                );
//                $event
//                    ->getGenerator()
//                    ->addUrl(
//                        new UrlConcrete(
//                            $url,
//                            new \DateTime(),
//                            UrlConcrete::CHANGEFREQ_HOURLY,
//                            1
//                        ),
//                        'default'
//                    );
//            }

        }
    }
}
