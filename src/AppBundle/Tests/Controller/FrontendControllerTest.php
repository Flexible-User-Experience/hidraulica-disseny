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
        $client = $this->createClient();         // anonymous user
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
            array('/ca/treballs/'),
            array('/ca/productes/'),
            array('/es/'),
            array('/es/trabajos/'),
            array('/es/productos/'),
            array('/en/'),
            array('/en/works/'),
            array('/en/products/'),
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
            array('/ca/pagina-trenacada/'),
            array('/es/pagina-rota/'),
            array('/en/broken-page/'),
        );
    }
}
