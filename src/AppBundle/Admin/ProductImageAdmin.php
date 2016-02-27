<?php

namespace AppBundle\Admin;

use AppBundle\Admin\AbstractBaseAdmin;
use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

/**
 * Class ProductImageAdmin
 *
 * @category Admin
 * @package  AppBundle\Admin
 * @author   Anton Serra <aserratorta@gmail.com>
 */
class ProductImageAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Image';
    protected $baseRoutePattern = 'products/image';
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
            ->with('backend.admin.image', $this->getFormMdSuccessBoxArray(6))
            ->add(
                'imageName',
                null,
                array(
                    'label'    => 'backend.admin.image_name',
                )
            )
            ->add(
                'createdAt',
                null,
                array(
                    'label'    => 'backend.admin.created_date',
                )
            )
            ->add(
                'alt',
                null,
                array(
                    'label'    => 'backend.admin.alt',
                )
            )
            ->end()
            ->with('backend.admin.controls', $this->getFormMdSuccessBoxArray(6))
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
                null,
                array(
                    'label'    => 'backend.admin.created_date',
                )
            )
            ->add(
                'imageName',
                null,
                array(
                    'label'    => 'backend.admin.image_name',
                )
            )
            ->add(
                'alt',
                null,
                array(
                    'label'    => 'backend.admin.alt',
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
                'position',
                null,
                array(
                    'label'    => 'backend.admin.position',
                )
            )
            ->add(
                'createdAt',
                null,
                array(
                    'label'    => 'backend.admin.created_date',
                )
            )
            ->add(
                'imageName',
                null,
                array(
                    'label'    => 'backend.admin.image_name',
                )
            )
            ->add(
                'alt',
                null,
                array(
                    'label'    => 'backend.admin.alt',
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
                    'actions' => array(
                        'show'   => array(),
                        'edit'   => array(),
                        'delete' => array(),
                    ),
                )
            );
    }
}
