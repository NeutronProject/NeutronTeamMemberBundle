<?php
namespace Neutron\Plugin\TeamMemberBundle\Form\Handler;

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberManagerInterface;

use Neutron\ComponentBundle\Form\Handler\AbstractFormHandler;

class TeamMemberHandler extends AbstractFormHandler
{

    protected $teamMemberManager;
    
    public function setTeamMemberManager(TeamMemberManagerInterface $teamMemberManager)
    {
        $this->teamMemberManager = $teamMemberManager;
    }
    
    protected function onSuccess()
    {
        $teamMember = $this->form->get('content')->getData();
        $this->teamMemberManager->update($teamMember, true);
    }
}