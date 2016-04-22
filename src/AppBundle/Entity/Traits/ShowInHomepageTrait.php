<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * ShowInHomepage trait
 *
 * @category Trait
 * @package  AppBundle\Entity\Traits
 * @author   David Romaní <david@flux.cat>
 */
Trait ShowInHomepageTrait
{
    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", options={"default" = true})
     */
    protected $showInHomepage = true;

    /**
     * Get ShowInHomepage
     *
     * @return boolean
     */
    public function getShowInHomepage()
    {
        return $this->showInHomepage;
    }

    /**
     * Set ShowInHomepage
     *
     * @param boolean $showInHomepage
     *
     * @return $this
     */
    public function setShowInHomepage($showInHomepage)
    {
        $this->showInHomepage = $showInHomepage;

        return $this;
    }
}
