<?php

namespace AppBundle\Admin;

use AppBundle\Admin\AbstractBaseAdmin;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class WorkAdmin
 *
 * @category Admin
 * @package  AppBundle\Admin
 * @author   Anton Serra <aserratorta@gmail.com>
 */
class WorkAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Work';
    protected $baseRoutePattern = 'works/work';
    protected $datagridValues = array(
        '_sort_by'    => 'createdAt',
        '_sort_order' => 'desc',
    );

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('backend.admin.general', $this->getFormMdSuccessBoxArray(9))
            ->add(
                'createdAt',
                'sonata_type_date_picker',
                array(
                    'label'  => 'backend.admin.created_date',
                    'format' => 'd/M/y',
                )
            )
            ->add(
                'title',
                null,
                array(
                    'label'    => 'backend.admin.title',
                )
            )
            ->add(
                'description',
                'ckeditor',
                array(
                    'config_name' => 'my_config',
                    'label'    => 'backend.admin.description',
                )
            )
            ->add(
                'mainImage',
                null,
                array(
                    'label'    => 'backend.admin.main_image',
                )
            )
            ->end()
            ->with('backend.admin.controls', $this->getFormMdSuccessBoxArray(3))
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
                'createdAt',
                'doctrine_orm_date',
                array(
                    'label'      => 'backend.admin.created_date',
                    'field_type' => 'sonata_type_date_picker',
                    'format'     => 'd-m-Y',
                )
            )
            ->add(
                'title',
                null,
                array(
                    'label'    => 'backend.admin.title',
                )
            )
            ->add(
                'description',
                null,
                array(
                    'label'    => 'backend.admin.description',
                )
            )
            ->add(
                'mainImage',
                null,
                array(
                    'label'    => 'backend.admin.main_image',
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
                'createdAt',
                'date',
                array(
                    'label'    => 'backend.admin.created_date',
                    'format'   => 'd/m/Y',
                    'editable' => true,
                )
            )
            ->add(
                'title',
                null,
                array(
                    'label'    => 'backend.admin.title',
                    'editable' => true,
                )
            )
            ->add(
                'description',
                null,
                array(
                    'label'    => 'backend.admin.description',
                )
            )
            ->add(
                'mainImage',
                null,
                array(
                    'label'    => 'backend.admin.main_image',

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

