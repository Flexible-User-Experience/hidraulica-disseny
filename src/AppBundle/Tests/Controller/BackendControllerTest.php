<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Tests\AbstractBaseTest;

/**
 * Class BackendTest
 *
 * @category Test
 * @package  AppBundle\Tests\Admin
 * @author   David Romaní <david@flux.cat>
 */
class BackendTest extends AbstractBaseTest
{
    /**
     * Test admin login request is successful
     */
    public function testAdminLoginPageIsSuccessful()
    {
        $client = $this->createClient();           // anonymous user
        $client->request('GET', '/admin/login');

        $this->assertStatusCode(200, $client);
    }

    /**
     * Test HTTP request is successful
     *
     * @dataProvider provideSuccessfulUrls
     * @param string $url
     */
    public function testAdminPagesAreSuccessful($url)
    {
        $client = $this->makeClient(true);         // authenticated user
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
            array('/admin/dashboard'),
            array('/admin/contact/message/list'),
            array('/admin/contact/message/1/show'),
            array('/admin/contact/message/1/answer'),
            array('/admin/works/category/list'),
            array('/admin/works/category/create'),
            array('/admin/works/category/1/delete'),
            array('/admin/works/work/list'),
            array('/admin/works/work/create'),
            array('/admin/works/work/1/edit'),
            array('/admin/works/work/1/delete'),
            array('/admin/works/image/list'),
            array('/admin/works/image/create'),
            array('/admin/works/image/1/edit'),
            array('/admin/works/image/1/delete'),
            array('/admin/products/product/list'),
            array('/admin/products/product/create'),
            array('/admin/products/product/1/edit'),
            array('/admin/products/product/1/delete'),
            array('/admin/products/image/list'),
            array('/admin/products/image/create'),
            array('/admin/products/image/1/edit'),
            array('/admin/products/image/1/delete'),
            array('/admin/carts/cart/list'),
            array('/admin/carts/cart/create'),
            array('/admin/carts/cart/1/edit'),
            array('/admin/carts/cart/1/delete'),
            array('/admin/carts/cart/1/show'),
            array('/admin/carts/customer/list'),
            array('/admin/carts/customer/1/show'),
            array('/admin/users/list'),
            array('/admin/users/create'),
            array('/admin/users/1/edit'),
            array('/admin/users/1/delete'),
        );
    }

    /**
     * Test HTTP request is not found
     *
     * @dataProvider provideNotFoundUrls
     * @param string $url
     */
    public function testAdminPagesAreNotFound($url)
    {
        $client = $this->makeClient(true);         // authenticated user
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
            array('/admin/contact/message/create'),
            array('/admin/contact/message/1/edit'),
            array('/admin/contact/message/1/delete'),
            array('/admin/contact/message/batch'),
            array('/admin/works/category/batch'),
            array('/admin/works/category/1/edit'),
            array('/admin/works/work/batch'),
            array('/admin/works/image/batch'),
            array('/admin/products/product/batch'),
            array('/admin/products/image/batch'),
            array('/admin/users/show'),
            array('/admin/users/batch'),
        );
    }
}
