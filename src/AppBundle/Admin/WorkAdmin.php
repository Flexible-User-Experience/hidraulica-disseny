<?php

namespace AppBundle\Admin;

use AppBundle\Admin\AbstractBaseAdmin;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

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
            ->with('backend.admin.general', $this->getFormMdSuccessBoxArray(6))
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
            );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'createdAt',
                null,
                array(
                    'label'    => 'backend.admin.created_date',
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
                null,
                array(
                    'label'    => 'backend.admin.created_date',
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
                    'actions' => array(
                        'show'   => array(),
                        'edit'   => array(),
                        'delete' => array(),
                    ),
                )
            );
    }
}

