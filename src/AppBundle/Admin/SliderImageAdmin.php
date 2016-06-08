<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

/**
 * Class SliderImageAdmin
 *
 * @category Admin
 * @package  AppBundle\Admin
 * @author   Anton Serra <aserratorta@gmail.com>
 */
class SliderImageAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Slider';
    protected $baseRoutePattern = 'sliders/image';
    protected $datagridValues = array(
        '_sort_by'    => 'position',
        '_sort_order' => 'asc',
    );

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('backend.admin.image', $this->getFormMdSuccessBoxArray(9))
            ->add(
                'imageFile',
                FileType::class,
                array(
                    'label'    => 'backend.admin.image',
                    'required' => false,
                    'help'     => $this->getImageHelperFormMapperWithThumbnail(),
                )
            )
            ->add(
                'url',
                null,
                array(
                    'label'    => 'Enllaç',
                    'required' => false,
                    'help'     => 'http://www.{URL}',
                )
            )
            ->add(
                'alt',
                null,
                array(
                    'label'    => 'backend.admin.alt',
                    'required' => false,
                    'help'     => 'metadescripció',
                )
            )
            ->end()
            ->with('backend.admin.controls', $this->getFormMdSuccessBoxArray(3))
            ->add(
                'position',
                null,
                array(
                    'label' => 'backend.admin.position',
                )
            )
            ->add(
                'enabled',
                'checkbox',
                array(
                    'label'    => 'backend.admin.enabled',
                    'required' => false,
                )
            )
            ->end();
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'url',
                null,
                array(
                    'label'    => 'Enllaç',
                )
            )
            ->add(
                'position',
                null,
                array(
                    'label' => 'backend.admin.position',
                )
            )
            ->add(
                'enabled',
                null,
                array(
                    'label'    => 'backend.admin.enabled',
                    'editable' => true,
                )
            );
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
        $listMapper
            ->add(
                'imageFile',
                null,
                array(
                    'label'    => 'backend.admin.image',
                    'template' => '::Admin/Cells/list__cell_image_field.html.twig'
                )
            )
            ->add(
                'url',
                null,
                array(
                    'label'    => 'Enllaç',
                    'editable' => true,
                )
            )
            ->add(
                'position',
                null,
                array(
                    'label'    => 'backend.admin.position',
                    'editable' => true,
                )
            )
            ->add(
                'enabled',
                null,
                array(
                    'label'    => 'backend.admin.enabled',
                    'editable' => true,
                )
            )
            ->add(
                '_action',
                'actions',
                array(
                    'label'   => 'backend.admin.actions',
                    'actions' => array(
                        'edit'   => array('template' => '::Admin/Buttons/list__action_edit_button.html.twig'),
                        'delete' => array('template' => '::Admin/Buttons/list__action_delete_button.html.twig'),
                    ),
                )
            );
    }
}

