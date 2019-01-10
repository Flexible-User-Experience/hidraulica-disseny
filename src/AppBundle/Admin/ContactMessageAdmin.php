<?php

namespace AppBundle\Admin;

use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\Form\Type\DatePickerType;

/**
 * Class ContactMessageAdmin
 *
 * @category Admin
 * @author   Anton Serra <aserratorta@gmail.com>
 */
class ContactMessageAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Contact Message';
    protected $baseRoutePattern = 'contact/message';
    protected $datagridValues = array(
        '_sort_by'    => 'createdAt',
        '_sort_order' => 'desc',
    );

    /**
     * Methods
     */

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
            ->remove('edit')
            ->remove('batch')
            ->add('answer', $this->getRouterIdParameter() . '/answer')
        ;
    }

    /**
     * @param DatagridMapper $datagridMapper
     */
    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add(
                'checked',
                null,
                array(
                    'label' => 'backend.admin.checked',
                )
            )
            ->add(
                'createdAt',
                'doctrine_orm_date',
                array(
                    'label'      => 'backend.admin.date',
                    'field_type' => DatePickerType::class,
                )
            )
            ->add(
                'name',
                null,
                array(
                    'label' => 'backend.admin.name',
                )
            )
            ->add(
                'email',
                null,
                array(
                    'label' => 'backend.admin.email',
                )
            )
            ->add(
                'subject',
                null,
                array(
                    'label' => 'backend.admin.subject',
                )
            )
            ->add(
                'message',
                null,
                array(
                    'label' => 'backend.admin.message',
                )
            )
            ->add(
                'answered',
                null,
                array(
                    'label' => 'backend.admin.answered',
                )
            )
            ->add(
                'description',
                null,
                array(
                    'label' => 'backend.admin.description',
                )
            )
        ;
    }

    /**
     * @param ShowMapper $showMapper
     */
    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->add(
                'checked',
                null,
                array(
                    'label' => 'backend.admin.checked',
                )
            )
            ->add(
                'createdAt',
                'date',
                array(
                    'label'  => 'backend.admin.date',
                    'format' => 'd/m/Y H:i',
                )
            )
            ->add(
                'name',
                null,
                array(
                    'label' => 'backend.admin.name',
                )
            )
            ->add(
                'email',
                null,
                array(
                    'label' => 'backend.admin.email',
                )
            )
            ->add(
                'subject',
                null,
                array(
                    'label' => 'backend.admin.subject',
                )
            )
            ->add(
                'message',
                'textarea',
                array(
                    'label' => 'backend.admin.message',
                )
            )
            ->add(
                'answered',
                null,
                array(
                    'label' => 'backend.admin.answered',
                )
            )
        ;
        if ($this->getSubject()->getAnswered()) {
            $showMapper
                ->add(
                    'description',
                    'textarea',
                    array(
                        'label' => 'backend.admin.answer',
                    )
                )
            ;
        }
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
        $listMapper
            ->add(
                'checked',
                null,
                array(
                    'label' => 'backend.admin.checked',
                )
            )
            ->add(
                'createdAt',
                'date',
                array(
                    'label'  => 'backend.admin.date',
                    'format' => 'd/m/Y'
                )
            )
            ->add(
                'name',
                null,
                array(
                    'label' => 'backend.admin.name',
                )
            )
            ->add(
                'email',
                null,
                array(
                    'label' => 'backend.admin.email',
                )
            )
            ->add(
                'subject',
                null,
                array(
                    'label' => 'backend.admin.subject',
                )
            )
            ->add(
                'answered',
                null,
                array(
                    'label' => 'backend.admin.answered',
                )
            )
            ->add(
                '_action',
                'actions',
                array(
                    'label' => 'backend.admin.actions',
                    'actions' => array(
                        'show'   => array(
                            'template' => '::Admin/Buttons/list__action_show_button.html.twig',
                        ),
                        'answer' => array(
                            'template' => '::Admin/Cells/list__action_answer.html.twig',
                        ),
                        'delete' => array(
                            'template' => '::Admin/Buttons/list__action_delete_button.html.twig',
                        ),
                    ),
                )
            )
        ;
    }
}
