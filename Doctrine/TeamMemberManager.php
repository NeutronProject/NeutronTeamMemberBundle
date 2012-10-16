<?php
namespace Neutron\Plugin\TeamMemberBundle\Doctrine;

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberManagerInterface;

use Neutron\ComponentBundle\Doctrine\AbstractManager;

class TeamMemberManager extends AbstractManager implements TeamMemberManagerInterface 
{
    public function getQueryBuilderForTeamMemberManagementDataGrid()
    {
        return $this->repository->getQueryBuilderForTeamMemberManagementDataGrid();
    }
    
    public function getQueryBuilderForTeamMemberFormDataGrid()
    {
        return $this->repository->getQueryBuilderForTeamMemberFormDataGrid();
    }
}
