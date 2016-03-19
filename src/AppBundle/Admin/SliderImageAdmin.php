<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

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
                'file',
                array(
                    'label'    => 'backend.admin.image',
                    'required'    => false,
                    'help'        => $this->getImageHelperFormMapperWithThumbnail(),
//                    'sonata_help' => $this->getImageHelperFormMapperWithThumbnail(),
                )
            )
            ->end()
            ->with('backend.admin.controls', $this->getFormMdSuccessBoxArray(3))
            ->add(
                'position',
                null,
                array(
                    'label'    => 'backend.admin.position',
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
                'position',
                null,
                array(
                    'label'    => 'backend.admin.position',
                )
            )
            ->add(
                'createdAt',
                'doctrine_orm_date',
                array(
                    'label'      => 'backend.admin.created_date',
                    'field_type' => 'sonata_type_date_picker',
                    'format'     => 'd-m-Y',
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
                'position',
                null,
                array(
                    'label'    => 'backend.admin.position',
                )
            )
            ->add(
                'createdAt',
                'date',
                array(
                    'label'    => 'backend.admin.created_date',
                    'format'   => 'd/m/Y',
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
                    'label' => 'backend.admin.actions',
                    'actions' => array(
                        'show'   => array(),
                        'edit'   => array(),
                        'delete' => array(),
                    ),
                )
            );
    }
}

