<?php

namespace AppBundle\Twig;

use AppBundle\Entity\Product;
use AppBundle\Entity\Work;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * Class AppExtension
 *
 * @category Twig
 * @package  ECVulco\AppBundle\Twig
 * @author   David Romaní <david@flux.cat>
 */
class AppExtension extends \Twig_Extension
{
    /**
     * @var UrlGeneratorInterface
     */
    private $generator;

    /**
     *
     *
     * Methods
     *
     *
     */

    /**
     * AppExtension constructor
     *
     * @param UrlGeneratorInterface $generator
     */
    public function __construct(UrlGeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Filters
     */

    /**
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('class_short_name', array($this, 'getClass')),
            new \Twig_SimpleFilter('is_product', array($this, 'isProductInstace')),
        );
    }

    /**
     * @param mixed $object
     *
     * @return string
     */
    public function getClass($object)
    {
        return (new \ReflectionClass($object))->getShortName();
    }

    /**
     * @param mixed $object
     *
     * @return string
     */
    public function isProductInstace($object)
    {
        return $object instanceof Product;
    }

    /**
     * Functions
     */

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('get_detail_path', array($this, 'getDetailPath'), array('is_safe_callback' => array($this, 'isUrlGenerationSafe'))),
        );
    }

    /**
     * @param object $object
     * @param array $parameters
     * @param bool  $relative
     *
     * @return string
     */
    public function getDetailPath($object, $parameters = array(), $relative = false)
    {
        $path = '';

        if ($object instanceof Work) {
            $path = 'app_work_detail';
        } else if ($object instanceof Product) {
            $path = 'app_product_detail';
        }

        return $this->generator->generate($path, $parameters, $relative ? UrlGeneratorInterface::RELATIVE_PATH : UrlGeneratorInterface::ABSOLUTE_PATH);
    }

    /**
     * Determines at compile time whether the generated URL will be safe and thus
     * saving the unneeded automatic escaping for performance reasons.
     *
     * The URL generation process percent encodes non-alphanumeric characters. So there is no risk
     * that malicious/invalid characters are part of the URL. The only character within an URL that
     * must be escaped in html is the ampersand ("&") which separates query params. So we cannot mark
     * the URL generation as always safe, but only when we are sure there won't be multiple query
     * params. This is the case when there are none or only one constant parameter given.
     * E.g. we know beforehand this will be safe:
     * - path('route')
     * - path('route', {'param': 'value'})
     * But the following may not:
     * - path('route', var)
     * - path('route', {'param': ['val1', 'val2'] }) // a sub-array
     * - path('route', {'param1': 'value1', 'param2': 'value2'})
     * If param1 and param2 reference placeholder in the route, it would still be safe. But we don't know.
     *
     * @param \Twig_Node $argsNode The arguments of the path/url function
     *
     * @return array An array with the contexts the URL is safe
     */
    public function isUrlGenerationSafe(\Twig_Node $argsNode)
    {
        // support named arguments
        $paramsNode = $argsNode->hasNode('parameters') ? $argsNode->getNode('parameters') : (
        $argsNode->hasNode(1) ? $argsNode->getNode(1) : null
        );

        if (null === $paramsNode || $paramsNode instanceof \Twig_Node_Expression_Array && count($paramsNode) <= 2 &&
            (!$paramsNode->hasNode(1) || $paramsNode->getNode(1) instanceof \Twig_Node_Expression_Constant)
        ) {
            return array('html');
        }

        return array();
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'class_twig_extension';
    }
}
