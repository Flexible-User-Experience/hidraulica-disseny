<?php

namespace AppBundle\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vat tax trait
 *
 * @category Trait
 * @package  AppBundle\Entity\Traits
 * @author   David Romaní <david@flux.cat>
 */
Trait VatTaxTrait
{
    /**
     * @var integer
     * @ORM\Column(type="integer", options={"default" = 0})
     */
    private $vatTax = 0;

    /**
     * Get VatTax
     *
     * @return int
     */
    public function getVatTax()
    {
        return $this->vatTax;
    }

    /**
     * Set VatTax
     *
     * @param int $vatTax
     *
     * @return $this
     */
    public function setVatTax($vatTax)
    {
        $this->vatTax = $vatTax;

        return $this;
    }
}
