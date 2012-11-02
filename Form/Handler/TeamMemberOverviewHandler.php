<?php
namespace Neutron\Plugin\TeamMemberBundle\Form\Handler;

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberOverviewManagerInterface;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

use Neutron\ComponentBundle\Form\Handler\AbstractFormHandler;

class TeamMemberOverviewHandler extends AbstractFormHandler
{
    
    protected function onSuccess()
    {
        $overview = $this->form->get('content')->getData();
        $category = $overview->getCategory();
        
        $this->container->get('neutron_team_member.team_member_overview_manager')->update($overview);
        
        $acl = $this->form->get('acl')->getData();
        
        $this->container->get('neutron_admin.acl.manager')
            ->setObjectPermissions(ObjectIdentity::fromDomainObject($category), $acl);
        
        $this->container->get('object_manager')->flush(); 
    }
    
    protected function getRedirectUrl()
    {
        return $this->container->get('router')->generate('neutron_mvc.category.management');
    }
}