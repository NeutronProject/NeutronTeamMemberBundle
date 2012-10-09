<?php
namespace Neutron\Plugin\CustomerServicesBundle\DataGrid;

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberManagerInterface;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

use Neutron\Bundle\DataGridBundle\DataGrid\FactoryInterface;

class TeamMemberFormDataGrid
{

    const IDENTIFIER = 'team_member_form';
    
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
                $this->translator->trans('grid.team_member_form.title',  array(), $this->translationDomain)
            )
            ->setAutoWidth(true)
            ->setColNames(array(
                $this->translator->trans('grid.team_member_form.name',  array(), $this->translationDomain),
                $this->translator->trans('grid.team_member_form.jobTitle',  array(), $this->translationDomain),
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
            ))
            ->setQueryBuilder($this->manager->getQueryBuilderForTeamMemberFormDataGrid())
            ->setSortName('m.name')
            ->setSortOrder('asc')
            ->enablePager(true)
            ->enableViewRecords(true)
            ->enableSearchButton(true)
       ;

        return $dataGrid;
    }



}