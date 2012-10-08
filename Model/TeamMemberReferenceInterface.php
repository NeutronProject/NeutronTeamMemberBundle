<?php
namespace src\Neutron\Plugin\TeamMemberBundle\Model;

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberOverviewInterface;

use Neutron\Bundle\FormBundle\Model\MultiSelectSortableReferenceInterface;

interface TeamMemberReferenceInterface extends MultiSelectSortableReferenceInterface
{
    public function setTeamMemberOverview(TeamMemberOverviewInterface $teamMemberOverview);
    
    public function getTeamMemberOverview();
}

