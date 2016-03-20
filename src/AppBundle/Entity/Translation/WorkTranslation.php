<?php

namespace AppBundle\Entity\Translation;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Translatable\Entity\MappedSuperclass\AbstractPersonalTranslation;

/**
 * Class WorkTranslation
 *
 * @category Translation
 * @package  AppBundle\Entity\Translation
 * @author   David Romaní <david@flux.cat>
 *
 * @ORM\Entity
 * @ORM\Table(name="work_translation",
 *   uniqueConstraints={@ORM\UniqueConstraint(name="lookup_work_unique_idx", columns={
 *     "locale", "object_id", "field"
 *   })}
 * )
 */
class WorkTranslation extends AbstractPersonalTranslation
{
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Work", inversedBy="translations")
     * @ORM\JoinColumn(name="object_id", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $object;
}
