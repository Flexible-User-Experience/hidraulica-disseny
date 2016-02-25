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
    protected $classnameLabel = 'Content';
    protected $baseRoutePattern = 'web/content';
    protected $datagridValues = array(
        '_sort_by'    => 'title',
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
                array()
            );
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'title',
                null,
                array()
            )
            ->add(
                'workImages',
                null,
                array()
            )
            ->add(
                'description',
                null,
                array()
            )
            ->add(
                'enabled',
                null,
                array()
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
                'title',
                null,
                array(
                    'editable' => true,
                )
            )
            ->add(
                'enabled',
                null,
                array(
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

