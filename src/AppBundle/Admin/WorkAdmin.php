<?php

namespace AppBundle\Admin;

use A2lix\TranslationFormBundle\Form\Type\GedmoTranslationsType;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;
use Sonata\CoreBundle\Form\Type\DatePickerType;
use Sonata\CoreBundle\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

/**
 * Class WorkAdmin.
 *
 * @category Admin
 *
 * @author   Anton Serra <aserratorta@gmail.com>
 */
class WorkAdmin extends AbstractBaseAdmin
{
    protected $classnameLabel = 'Work';
    protected $baseRoutePattern = 'works/work';
    protected $datagridValues = array(
        '_sort_by' => 'createdAt',
        '_sort_order' => 'desc',
    );

    /**
     * Methods.
     */

    /**
     * @param RouteCollection $collection
     */
    public function configureRoutes(RouteCollection $collection)
    {
        parent::configureRoutes($collection);
        $collection->add('preview', $this->getRouterIdParameter().'/preview');
    }

    /**
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('backend.admin.general', $this->getFormMdSuccessBoxArray(9))
            ->add(
                'imageFile',
                FileType::class,
                array(
                    'label' => 'backend.admin.image',
                    'help' => $this->getImageHelperFormMapperWithThumbnail(),
                    'required' => false,
                )
            )
            ->add(
                'title',
                null,
                array(
                    'label' => 'backend.admin.title',
                )
            )
            ->add(
                'description',
                TextareaType::class,
                array(
                    'attr' => array(
                        'rows' => 8,
                        'class' => 'tinymce',
                    ),
                    'label' => 'backend.admin.description',
                )
            )
            ->add(
                'urlVimeo',
                null,
                array(
                    'label' => 'Vimeo',
                    'help' => 'https://vimeo.com/NNNNNN',
                )
            )
            ->end()
            ->with('backend.admin.controls', $this->getFormMdSuccessBoxArray(3))
            ->add(
                'createdAt',
                DatePickerType::class,
                array(
                    'label' => 'backend.admin.created_date',
                    'format' => 'd/M/y',
                )
            )
            ->add(
                'category',
                null,
                array(
                    'label' => 'backend.admin.category',
                )
            )
            ->add(
                'showInHomepage',
                CheckboxType::class,
                array(
                    'label' => 'backend.admin.homepage',
                    'required' => false,
                )
            )
            ->add(
                'enabled',
                CheckboxType::class,
                array(
                    'label' => 'backend.admin.enabled',
                    'required' => false,
                )
            )
            ->end()
            ->with('backend.admin.translations', $this->getFormMdSuccessBoxArray(9))
            ->add(
                'translations',
                GedmoTranslationsType::class,
                array(
                    'required' => false,
                    'label' => ' ',
                    'translatable_class' => 'AppBundle\Entity\Translation\WorkTranslation',
                    'fields' => array(
                        'title' => array(
                            'label' => 'backend.admin.title',
                            'required' => false,
                        ),
                        'description' => array(
                            'label' => 'backend.admin.description',
                            'attr' => array(
                                'rows' => 8,
                                'class' => 'tinymce',
                            ),
                            'required' => false,
                        ),
                    ),
                )
            )
            ->end()
        ;
        if ($this->id($this->getSubject())) { // is edit mode, disable on new subjects
            $formMapper
                ->with('backend.admin.images', $this->getFormMdSuccessBoxArray(12))
                ->add(
                    'images',
                    CollectionType::class,
                    array(
                        'label' => ' ',
                        'required' => false,
                        'cascade_validation' => true,
                    ),
                    array(
                        'edit' => 'inline',
                        'inline' => 'table',
                        'sortable' => 'position',
                    )
                )
                ->end()
                ->setHelps(
                    array('images' => 'up to 10MB with format PNG, JPG or GIF. min. width 1200px.')
                )
            ;
        }
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
                    'label' => 'backend.admin.created_date',
                    'field_type' => DatePickerType::class,
                    'format' => 'd-m-Y',
                )
            )
            ->add(
                'title',
                null,
                array(
                    'label' => 'backend.admin.title',
                )
            )
            ->add(
                'category',
                null,
                array(
                    'label' => 'backend.admin.category',
                )
            )
            ->add(
                'description',
                null,
                array(
                    'label' => 'backend.admin.description',
                )
            )
            ->add(
                'showInHomepage',
                null,
                array(
                    'label' => 'backend.admin.homepage',
                )
            )
            ->add(
                'enabled',
                null,
                array(
                    'label' => 'backend.admin.enabled',
                    'editable' => true,
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
                'imageFile',
                null,
                array(
                    'label' => 'backend.admin.image',
                    'template' => '::Admin/Cells/list__cell_image_field.html.twig',
                )
            )
            ->add(
                'createdAt',
                'date',
                array(
                    'label' => 'backend.admin.created_date',
                    'format' => 'd/m/Y',
                    'editable' => true,
                )
            )
            ->add(
                'title',
                null,
                array(
                    'label' => 'backend.admin.title',
                    'editable' => true,
                )
            )
            ->add(
                'category',
                null,
                array(
                    'label' => 'backend.admin.category',
                )
            )
            ->add(
                'showInHomepage',
                null,
                array(
                    'label' => 'backend.admin.homepage',
                    'editable' => true,
                )
            )
            ->add(
                'enabled',
                null,
                array(
                    'label' => 'backend.admin.enabled',
                    'editable' => true,
                )
            )
            ->add(
                '_action',
                'actions',
                array(
                    'label' => 'backend.admin.actions',
                    'actions' => array(
                        'preview' => array('template' => '::Admin/Buttons/list__action_preview_button.html.twig'),
                        'edit' => array('template' => '::Admin/Buttons/list__action_edit_button.html.twig'),
                        'delete' => array('template' => '::Admin/Buttons/list__action_delete_button.html.twig'),
                    ),
                )
            )
        ;
    }
}
