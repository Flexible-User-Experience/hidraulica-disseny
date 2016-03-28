<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Product;
use AppBundle\Repository\WorkRepository;
use AppBundle\Repository\ProductRepository;
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

    /** @var WorkRepository */
    private $wr;

    /** @var ProductRepository */
    private $pr;

    /**
     * SitemapListener constructor
     *
     * @param RouterInterface   $router
     * @param WorkRepository    $wr
     * @param ProductRepository $pr
     */
    public function __construct(RouterInterface $router, WorkRepository $wr, ProductRepository $pr)
    {
        $this->router = $router;
        $this->wr = $wr;
        $this->pr = $pr;
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
            // Products
            $event
                ->getGenerator()
                ->addUrl(
                    new UrlConcrete(
                        $this->router->generate('app_product_list', array(), UrlGeneratorInterface::ABSOLUTE_URL),
                        new \DateTime(),
                        UrlConcrete::CHANGEFREQ_HOURLY,
                        1
                    ),
                    'default'
                );
            $products = $this->pr->findAllEnabledSortedByDate();
            /** @var Product $product */
            foreach ($products as $product) {
                $event
                    ->getGenerator()
                    ->addUrl(
                        new UrlConcrete(
                            $this->router->generate('app_product_detail', array('slug' => $product->getSlug()), UrlGeneratorInterface::ABSOLUTE_URL),
                            new \DateTime(),
                            UrlConcrete::CHANGEFREQ_HOURLY,
                            1
                        ),
                        'default'
                    );
            }
            // Works
            $event
                ->getGenerator()
                ->addUrl(
                    new UrlConcrete(
                        $this->router->generate('app_work_list', array(), UrlGeneratorInterface::ABSOLUTE_URL),
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
