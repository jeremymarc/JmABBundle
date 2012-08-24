<?php

namespace Jm\ABBundle\Admin;

use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\AdminBundle\Admin\Admin;

class TemplateAdmin extends Admin
{
    protected function configureShowField(ShowMapper $showMapper)
    {
        $showMapper
            ->add('id')
            ->add('name')
            ->add('body')
            ->add('variationBody')
            ->add('experimentCode')
        ;
    }

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('General')
                ->add('name')
                ->add('body')
                ->add('variationBody')
                ->add('experimentCode')
            ->end()
        ;
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('name')
            ->add('experimentCode')
            ->add('_action', 'actions', array(
                'actions' => array(
                    'view'   => array(),
                    'edit'   => array(),
                    'delete' => array(),
                )
            ))
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper
            ->add('name')
            ->add('body')
            ->add('variationBody')
            ;
    }
}



