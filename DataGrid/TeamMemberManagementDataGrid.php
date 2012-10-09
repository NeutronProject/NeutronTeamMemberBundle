<?php
namespace Neutron\Plugin\TeamMemberBundle\DataGrid;

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberManagerInterface;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

use Neutron\Bundle\DataGridBundle\DataGrid\FactoryInterface;

class TeamMemberManagementDataGrid
{

    const IDENTIFIER = 'team_member_management';
    
    protected $factory;
    
    protected $translator;
    
    protected $router;
    
    protected $manager;
    
    protected $translationDomain;
   

    public function __construct (FactoryInterface $factory, Translator $translator, Router $router, 
             TeamMemberManagerInterface $manager, $translationDomain)
    {
        $this->factory = $factory;
        $this->translator = $translator;
        $this->router = $router;
        $this->manager = $manager;
        $this->translationDomain = $translationDomain;
    }

    public function build ()
    {
        
        $dataGrid = $this->factory->createDataGrid(self::IDENTIFIER);
        $dataGrid
            ->setCaption(
                $this->translator->trans('grid.team_member_management.title',  array(), $this->translationDomain)
            )
            ->setAutoWidth(true)
            ->setColNames(array(
                $this->translator->trans('grid.team_member_management.name',  array(), $this->translationDomain),
                $this->translator->trans('grid.team_member_management.jobTitle',  array(), $this->translationDomain),
                $this->translator->trans('grid.team_member_management.enabled',  array(), $this->translationDomain),
            ))
            ->setColModel(array(
                array(
                    'name' => 'm.name', 'index' => 'm.name', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                    
                array(
                    'name' => 'm.jobTitle', 'index' => 'm.jobTitle', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => false,
                ), 

                array(
                    'name' => 'm.enabled', 'index' => 'm.enabled', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                    'formatter' => 'checkbox',  'search' => true, 'stype' => 'select',
                    'searchoptions' => array('value' => array(
                        1 => $this->translator->trans('grid.enabled', array(), $this->translationDomain), 
                        0 => $this->translator->trans('grid.disabled', array(), $this->translationDomain), 
                    ))
                ), 

            ))
            ->setQueryBuilder($this->manager->getQueryBuilderForTeamMemberManagementDataGrid())
            ->setSortName('m.name')
            ->setSortOrder('asc')
            ->enablePager(true)
            ->enableViewRecords(true)
            ->enableSearchButton(true)
            ->enableAddButton(true)
            ->setAddBtnUri($this->router->generate('neutron_team_member.backend.team_member.update', array(), true))
            ->enableEditButton(true)
            ->setEditBtnUri($this->router->generate('neutron_team_member.backend.team_member.update', array('id' => '{id}'), true))
            ->enableDeleteButton(true)
            ->setDeleteBtnUri($this->router->generate('neutron_team_member.backend.team_member.delete', array('id' => '{id}'), true))
        ;

        return $dataGrid;
    }



}