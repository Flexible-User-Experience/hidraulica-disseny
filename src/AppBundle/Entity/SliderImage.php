<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use AppBundle\Entity\Traits\ImageTrait;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Class SliderImage
 *
 * @category Entity
 * @package  AppBundle\Entity
 * @author   Anton Serra <aserratorta@gmail.com>
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SliderImageRepository")
 * @Vich\Uploadable
 */
class SliderImage extends AbstractBase
{
    use ImageTrait;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="slide", fileNameProperty="imageName")
     * @Assert\File(
     *     maxSize = "10M",
     *     mimeTypes = {"image/jpg", "image/jpeg", "image/png", "image/gif"}
     * )
     * @Assert\Image(minWidth = 1200)
     */
    private $imageFile;
}
