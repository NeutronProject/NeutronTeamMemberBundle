<?php
namespace Neutron\Plugin\TeamMemberBundle\Form\Handler;

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberManagerInterface;

use Neutron\ComponentBundle\Form\Handler\AbstractFormHandler;

class TeamMemberHandler extends AbstractFormHandler
{

    protected function onSuccess()
    {
        $teamMember = $this->form->get('content')->getData();
        $this->container->get('neutron_team_member.team_member_manager')->update($teamMember, true);
    }
    
    protected function getRedirectUrl()
    {
        return $this->container->get('router')->generate('neutron_team_member.backend.team_member');
    }
}