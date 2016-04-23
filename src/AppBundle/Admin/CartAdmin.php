<?php

namespace AppBundle\Admin;

use Doctrine\ORM\QueryBuilder;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use AppBundle\Enum\CartStatusEnum;
use Sonata\AdminBundle\Show\ShowMapper;

/**
 * Class CartAdmin
 *
 * @category Admin
 * @package  AppBundle\Admin
 * @author   Anton Serra <aserratorta@gmail.com>
 */
class CartAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Cart';
    protected $baseRoutePattern = 'carts/cart';
    protected $datagridValues = array(
        '_sort_by'    => 'createdAt',
        '_sort_order' => 'desc',
    );

    /**
     * Configure route collection
     *
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('create')
            ->remove('delete')
            ->remove('edit')
            ->remove('batch');
    }

    /**
     * Override query list to reduce queries amount on list view (apply join strategy)
     *
     * @param string $context context
     *
     * @return QueryBuilder
     */
    public function createQuery($context = 'list')
    {
        /** @var QueryBuilder $query */
        $query = parent::createQuery($context);
        $query
            ->select($query->getRootAliases()[0] . ', i')
            ->leftJoin($query->getRootAliases()[0] . '.items', 'i');

        return $query;
    }

    protected function configureShowFields(ShowMapper $showMapper)
    {
        $showMapper
            ->with('backend.admin.cart.customer.customer', $this->getFormMdSuccessBoxArray(6))
            ->add(
                'customer.name',
                null,
                array(
                    'label' => 'backend.admin.cart.customer.name',
                )
            )
            ->add(
                'customer.address',
                null,
                array(
                    'label' => 'backend.admin.cart.customer.address',
                )
            )
            ->add(
                'customer.postalCode',
                null,
                array(
                    'label' => 'backend.admin.cart.customer.postal_code',
                )
            )
            ->add(
                'customer.city',
                null,
                array(
                    'label' => 'backend.admin.cart.customer.city',
                )
            )
            ->add(
                'customer.state',
                null,
                array(
                    'label' => 'backend.admin.cart.customer.state',
                )
            )
            ->add(
                'customer.country',
                null,
                array(
                    'label' => 'backend.admin.cart.customer.country',
                )
            )
            ->add(
                'customer.phone',
                null,
                array(
                    'label' => 'backend.admin.cart.customer.phone',
                )
            )
            ->add(
                'customer.email',
                null,
                array(
                    'label' => 'backend.admin.cart.customer.email',
                )
            )
            ->end()
            ->with('backend.admin.cart.status.status', $this->getFormMdSuccessBoxArray(6))
            ->add(
                'createdAt',
                null,
                array(
                    'label'  => 'backend.admin.created_date',
                    'format' => 'd/M/y',
                )
            )
            ->add(
                'statusHumanFriendly',
                null,
                array(
                    'label'   => 'backend.admin.cart.status.status',
                    'choices' => CartStatusEnum::getEnumArray(),
                )
            )
            ->end()
            ->with('backend.admin.cart.items', $this->getFormMdSuccessBoxArray(12))
            ->add(
                'items',
                null,
                array(
                    'label' => 'backend.admin.cart.items',
                )
            )
            ->add(
                'baseAmount',
                null,
                array(
                    'label' => 'Base imposable',
                )
            )
            ->add(
                'deliveryAmount',
                null,
                array(
                    'label' => 'Enviament',
                )
            )
            ->add(
                'vatTax',
                null,
                array(
                    'label' => 'IVA',
                )
            )
            ->add(
                'totalAmount',
                null,
                array(
                    'label' => 'Total',
                )
            )
            ->end();
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('backend.admin.general', $this->getFormMdSuccessBoxArray(9))
            ->add(
                'items',
                null,
                array(
                    'label' => 'backend.admin.cart.items',
                )
            )
            ->end()
            ->with('backend.admin.controls', $this->getFormMdSuccessBoxArray(3))
            ->add(
                'createdAt',
                'sonata_type_date_picker',
                array(
                    'label'  => 'backend.admin.created_date',
                    'format' => 'd/M/y',
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
                'createdAt',
                'doctrine_orm_date',
                array(
                    'label'      => 'backend.admin.created_date',
                    'field_type' => 'sonata_type_date_picker',
                    'format'     => 'd-m-Y',
                )
            )
            ->add(
                'customer',
                null,
                array(
                    'label' => 'backend.admin.cart.customer.customer',
                )
            )
            ->add(
                'status',
                null,
                array('label' => 'backend.admin.cart.status.status'),
                'choice',
                array(
                    'expanded' => false,
                    'multiple' => false,
                    'choices'  => CartStatusEnum::getEnumArray(),
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
                    'editable' => false,
                )
            )
            ->add(
                'customer',
                null,
                array(
                    'label' => 'backend.admin.cart.customer.customer',
                )
            )
            ->add(
                'nitems',
                null,
                array(
                    'label'    => 'backend.admin.cart.nitems',
                    'template' => '::Admin/Cells/list__cell_cart_nitems.html.twig',
                )
            )
            ->add(
                'baseAmount',
                null,
                array(
                    'label'    => 'backend.admin.cart.total_amount',
                    'template' => '::Admin/Cells/list__cell_cart_total_amount.html.twig',
                )
            )
            ->add(
                'status',
                null,
                array(
                    'label'    => 'backend.admin.cart.status.status',
                    'template' => '::Admin/Cells/list__cell_cart_status.html.twig',
                )
            )
            ->add(
                '_action',
                'actions',
                array(
                    'label'   => 'backend.admin.actions',
                    'actions' => array(
                        'show' => array('template' => '::Admin/Buttons/list__action_show_button.html.twig'),

                    ),
                )
            );
    }
}

