<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\AbstractBaseTest;

/**
 * Class FrontendControllerTest
 *
 * @category Test
 * @package  AppBundle\Tests\Controller
 * @author   David Romaní <david@flux.cat>
 */
class FrontendControllerTest extends AbstractBaseTest
{
    /**
     * Test HTTP request is successful
     *
     * @dataProvider provideSuccessfulUrls
     * @param string $url
     */
    public function testPagesAreSuccessful($url)
    {
        $client = $this->createClient();
        $client->request('GET', $url);

        $this->assertStatusCode(200, $client);
    }

    /**
     * Successful Urls provider
     *
     * @return array
     */
    public function provideSuccessfulUrls()
    {
        return array(
            array('/ca/'),
            array('/ca/treballs'),
            array('/ca/treball/my-work'),
            array('/ca/productes'),
            array('/ca/producte/my-product'),
            array('/ca/sobre-nosaltres'),
            array('/ca/contacte'),
            array('/es/'),
            array('/es/trabajos'),
            array('/es/trabajo/my-work'),
            array('/es/productos'),
            array('/es/producto/my-product'),
            array('/es/sobre-nosotros'),
            array('/es/contacto'),
            array('/en/'),
            array('/en/works'),
            array('/en/work/my-work'),
            array('/en/products'),
            array('/en/product/my-product'),
            array('/en/about-us'),
            array('/en/contact'),
            array('/sitemap/sitemap.default.xml'),
        );
    }

    /**
     * Test HTTP request is not found
     *
     * @dataProvider provideNotFoundUrls
     * @param string $url
     */
    public function testPagesAreNotFound($url)
    {
        $client = $this->createClient();         // anonymous user
        $client->request('GET', $url);

        $this->assertStatusCode(404, $client);
    }

    /**
     * Not found Urls provider
     *
     * @return array
     */
    public function provideNotFoundUrls()
    {
        return array(
            array('/ca/pagina-trenacada'),
            array('/es/pagina-rota'),
            array('/en/broken-page'),
        );
    }
}
