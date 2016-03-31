<?php

namespace AppBundle\Listener;

use AppBundle\Entity\Work;
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

    /** @var array */
    private $locales;

    /**
     * SitemapListener constructor
     *
     * @param RouterInterface   $router
     * @param WorkRepository    $wr
     * @param ProductRepository $pr
     * @param array             $locales
     */
    public function __construct(RouterInterface $router, WorkRepository $wr, ProductRepository $pr, array $locales)
    {
        $this->router = $router;
        $this->wr = $wr;
        $this->pr = $pr;
        $this->locales = $locales;
    }

    /**
     * @param SitemapPopulateEvent $event
     */
    public function populateSitemap(SitemapPopulateEvent $event)
    {
        $section = $event->getSection();
        if (is_null($section) || $section == 'default') {
            /** @var string $locale */
            foreach ($this->locales as $locale) {
// Homepage
                $event
                    ->getGenerator()
                    ->addUrl(
                        new UrlConcrete(
                            $this->router->generate('app_homepage', array('_locale' => $locale), UrlGeneratorInterface::ABSOLUTE_URL),
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
                            $this->router->generate('app_product_list', array('_locale' => $locale), UrlGeneratorInterface::ABSOLUTE_URL),
                            new \DateTime(),
                            UrlConcrete::CHANGEFREQ_HOURLY,
                            1
                        ),
                        'default'
                    );
                /** @var Product $product */
                foreach ($this->pr->findAllEnabledSortedByDate() as $product) {
                    $event
                        ->getGenerator()
                        ->addUrl(
                            new UrlConcrete(
                                $this->router->generate('app_product_detail', array('_locale' => $locale, 'slug' => $product->getSlug()), UrlGeneratorInterface::ABSOLUTE_URL),
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
                            $this->router->generate('app_work_list', array('_locale' => $locale), UrlGeneratorInterface::ABSOLUTE_URL),
                            new \DateTime(),
                            UrlConcrete::CHANGEFREQ_HOURLY,
                            1
                        ),
                        'default'
                    );
                /** @var Work $work */
                foreach ($this->wr->findAllEnabledSortedByDate() as $work) {
                    $event
                        ->getGenerator()
                        ->addUrl(
                            new UrlConcrete(
                                $this->router->generate('app_work_detail', array('_locale' => $locale, 'slug' => $work->getSlug()), UrlGeneratorInterface::ABSOLUTE_URL),
                                new \DateTime(),
                                UrlConcrete::CHANGEFREQ_HOURLY,
                                1
                            ),
                            'default'
                        );
                }
                // About
                $event
                    ->getGenerator()
                    ->addUrl(
                        new UrlConcrete(
                            $this->router->generate('app_about', array('_locale' => $locale), UrlGeneratorInterface::ABSOLUTE_URL),
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
                            $this->router->generate('app_contact', array('_locale' => $locale), UrlGeneratorInterface::ABSOLUTE_URL),
                            new \DateTime(),
                            UrlConcrete::CHANGEFREQ_HOURLY,
                            1
                        ),
                        'default'
                    );
            }
        }
    }
}
