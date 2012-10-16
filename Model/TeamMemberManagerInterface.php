<?php
namespace Neutron\Plugin\TeamMemberBundle\Model;

interface TeamMemberManagerInterface
{
    public function getQueryBuilderForTeamMemberManagementDataGrid();
    
    public function getQueryBuilderForTeamMemberFormDataGrid();
}
