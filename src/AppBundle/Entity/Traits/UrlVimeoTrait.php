<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * UrlVimeoTrait trait
 *
 * @category Trait
 * @package  AppBundle\Entity\Traits
 * @author   David Romaní <david@flux.cat>
 */
Trait UrlVimeoTrait
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url(checkDNS=true)
     */
    private $urlVimeo;

    /**
     * Get UrlVimeo
     *
     * @return string
     */
    public function getUrlVimeo()
    {
        return $this->urlVimeo;
    }

    /**
     * Set UrlVimeo
     *
     * @param string $urlVimeo
     *
     * @return $this
     */
    public function setUrlVimeo($urlVimeo)
    {
        $this->urlVimeo = $urlVimeo;

        return $this;
    }

    /**
     * Get urlVimeo
     *
     * @return int
     */
    public function getVimeoId()
    {
        $result = null;
        if ($this->urlVimeo) {
            $arr = explode('/', $this->getUrlVimeo());
            $result = intval(array_pop($arr));
        }

        return $result;
    }
}
