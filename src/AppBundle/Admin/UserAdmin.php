<?php

namespace AppBundle\Admin;

use AppBundle\Enum\UserRolesEnum;
use Sonata\UserBundle\Admin\Model\UserAdmin as ParentUserAdmin;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

/**
 * Class UserAdmin
 *
 * @category Admin
 * @author   David Romaní <david@flux.cat>
 */
class UserAdmin extends ParentUserAdmin
{
    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    protected $classnameLabel = 'User';
    protected $baseRoutePattern = 'users';
    protected $datagridValues = array(
        '_sort_by'    => 'username',
        '_sort_order' => 'asc',
    );

    /**
     * Methods
     */

    /**
     * @param $code
     * @param $class
     * @param $baseControllerName
     * @param $userManager
     */
    public function __construct($code, $class, $baseControllerName, $userManager)
    {
        parent::__construct($code, $class, $baseControllerName);
        $this->userManager = $userManager;
    }

    /**
     * @param RouteCollection $collection
     */
    protected function configureRoutes(RouteCollection $collection)
    {
        $collection
            ->remove('batch')
            ->remove('export')
            ->remove('show')
        ;
    }

    /**
     * @return array
     */
    public function getBatchActions()
    {
        $actions = parent::getBatchActions();
        unset($actions['delete']);

        return $actions;
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        /** @var object $formMapper */
        $formMapper
            ->with('backend.admin.general', array('class' => 'col-md-6'))
            ->add(
                'firstname',
                null,
                array(
                    'label'    => 'backend.admin.firstname',
                    'required' => false,
                )
            )
            ->add(
                'username',
                null,
                array(
                    'label' => 'backend.admin.username',
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
                'plainPassword',
                TextType::class,
                array(
                    'label'    => 'backend.admin.plain_password',
                    'required' => (!$this->getSubject() || is_null($this->getSubject()->getId()))
                )
            )
            ->end()
            ->with('backend.admin.controls', array('class' => 'col-md-6'))
            ->add(
                'roles',
                ChoiceType::class,
                array(
                    'label'    => 'backend.admin.roles',
                    'choices'  => UserRolesEnum::getEnumArray(),
                    'multiple' => true,
                    'expanded' => true
                )
            )
            ->add(
                'enabled',
                CheckboxType::class,
                array(
                    'label'    => 'backend.admin.enabled',
                    'required' => false,
                )
            )
            ->end()
        ;
    }

    /**
     * @param DatagridMapper $filterMapper
     */
    protected function configureDatagridFilters(DatagridMapper $filterMapper)
    {
        $filterMapper
            ->add(
                'username',
                null,
                array(
                    'label' => 'backend.admin.username',
                )
            )
            ->add(
                'email',
                null,
                array(
                    'label' => 'backend.admin.email',
                )
            )
//            ->add(
//                'roles',
//                'doctrine_orm_string',
//                array(
//                    'choice',
//                    array('choices' => UserRolesEnum::getEnumArray()),
//                )
//            )
            ->add(
                'enabled',
                null,
                array(
                    'label' => 'backend.admin.enabled',
                )
            )
        ;
    }

    /**
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        unset($this->listModes['mosaic']);
        $listMapper
            ->add(
                'username',
                null,
                array(
                    'label'    => 'backend.admin.username',
                    'editable' => true,
                )
            )
            ->add(
                'email',
                null,
                array(
                    'label'    => 'backend.admin.email',
                    'editable' => true,
                )
            )
            ->add(
                'roles',
                null,
                array(
                    'label'    => 'backend.admin.roles',
                    'template' => '::Admin/Cells/list__cell_user_roles.html.twig',
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
            )
        ;
    }
}
