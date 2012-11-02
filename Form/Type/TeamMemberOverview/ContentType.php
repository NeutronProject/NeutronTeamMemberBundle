<?php
/*
 * This file is part of NeutronTeamMemberBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Plugin\TeamMemberBundle\Form\Type\TeamMemberOverview;

use Neutron\Bundle\DataGridBundle\DataGrid\DataGridInterface;

use Symfony\Component\Form\FormView;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

/**
 * Short description
 *
 * @author Zender <azazen09@gmail.com>
 * @since 1.0
 */
class ContentType extends AbstractType
{
    protected $dataGrid;
    
    protected $teamMemberOverviewClass;
    
    protected $teamMemberClass;
    
    protected $teamMemberReferenceClass;
    
    protected $templates;
    
    protected $translationDomain;
    
    public function setDataGrid(DataGridInterface $dataGrid)
    {
        $this->dataGrid = $dataGrid;
    }
    
    public function setTeamMemberOverviewClass($teamMemberOverviewClass)
    {
        $this->teamMemberOverviewClass = $teamMemberOverviewClass;
    }
    
    public function setTeamMemberClass($teamMemberClass)
    {
        $this->teamMemberClass = $teamMemberClass;
    }
    
    public function setTeamMemberReferenceClass($teamMemberReferenceClass)
    {
        $this->teamMemberReferenceClass = $teamMemberReferenceClass;
    }
    
    public function setTemplates($templates)
    {
        $this->templates = $templates;
    }
    
    public function setTranslationDomain($translationDomain)
    {
        $this->translationDomain = $translationDomain;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
       
           ->add('references', 'neutron_multi_select_sortable_collection', array(
               'label' => 'form.reference',
               'grid' => $this->dataGrid,
               'translation_domain' => $this->translationDomain,
               'options' => array(
                   'data_class' => $this->teamMemberReferenceClass,
                   'inversed_class' => $this->teamMemberClass,
                   'inversed_name' => 'inversed',
               )
           ))
           ->add('template', 'choice', array(
               'choices' => $this->templates,
               'multiple' => false,
               'expanded' => false,
               'attr' => array('class' => 'uniform'),
               'label' => 'form.template',
               'empty_value' => 'form.empty_value',
               'translation_domain' => $this->translationDomain
           ))
       ;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->teamMemberOverviewClass,
            'validation_groups' => function(FormInterface $form){
                return 'default';
            },
        ));
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'neutron_team_member_overview_content';
    }
}