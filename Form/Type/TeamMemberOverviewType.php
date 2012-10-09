<?php
/*
 * This file is part of NeutronTeamMemberBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Plugin\TeamMemberBundle\Form\Type;

use Neutron\AdminBundle\Acl\AclManagerInterface;

use Neutron\MvcBundle\Plugin\PluginInterface;

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
class TeamMemberOverviewType extends AbstractType
{
    
    protected $aclManager;
    
    protected $plugin;
    
    protected $dataGridName;
    
    protected $teamMemberOverviewClass;
    
    protected $teamMemberClass;
    
    protected $teamMemberReferenceClass;
    
    public function setAclManager(AclManagerInterface $aclManager)
    {
        $this->aclManager = $aclManager;
    }
    
    public function setPlugin(PluginInterface $plugin)
    {
        $this->plugin = $plugin;
    }
    
    public function setDataGridName($dataGridName)
    {
        $this->dataGridName = $dataGridName;
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
        $this->teamMemberClass = $teamMemberReferenceClass;
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder->add('general', 'neutron_category');
       $builder->add('content', 'neutron_team_member_overview_content');
       $builder->add('services', 'neutron_multi_select_sortable_form', array(
           'grid_name' => $this->dataGridName,
           'data_class' => $this->teamMemberOverviewClass,
           'inversed_class' => $this->teamMemberClass,
           'reference_class' => $this->teamMemberReferenceClass,
       ));
       $builder->add('seo', 'neutron_seo');
       
       if (count($this->plugin->getPanels()) > 0){
           $builder->add('panels', 'neutron_panels', array(
               'plugin' => $this->plugin->getName(),
               'pluginIdentifier' => $this->plugin->getName(),
           ));
       }
       
       if ($this->aclManager->isAclEnabled()){
           $builder->add('acl', 'neutron_admin_form_acl_collection', array(
               'masks' => array(
                   'VIEW' => 'View',
               ),
           ));
       }
    } 
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false,
            'cascade_validation' => true,
        ));
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'neutron_team_member_overview';
    }
}