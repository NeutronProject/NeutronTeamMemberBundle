<?php
namespace Neutron\Plugin\TeamMemberBundle\Form\Handler;

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberOverviewManagerInterface;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

use Neutron\ComponentBundle\Form\Handler\AbstractFormHandler;

class TeamMemberOverviewHandler extends AbstractFormHandler
{
    protected $plugin;
    
    protected $teamMemberOverviewManager;
    
    protected $aclManager;
    
    public function setAclManager(AclManagerInterface $aclManager)
    {
        $this->aclManager = $aclManager;
        return $this;
    }
    
    public function setTeamMemberOverviewManager(TeamMemberOverviewManagerInterface $teamMemberOverviewManager)
    {
        $this->teamMemberOverviewManager = $teamMemberOverviewManager;
    }
    
    
    public function setPlugin(PluginInterface $plugin)
    {
        $this->plugin = $plugin;
        return $this;
    }
    
    protected function onSuccess()
    {
        $overview = $this->form->get('content')->getData();
        $category = $overview->getCategory();
        
        $mvcManager = $this->plugin->getMvcManager();
        
        $this->teamMemberOverviewManager->update($overview);
        
        if (count($this->plugin->getPanels()) > 0){
            $panels = $this->form->get('panels')->getData();
            $mvcManager->updatePanels($overview->getId(), $panels);
        }
        
        $this->om->flush();
        
        $acl = $this->form->get('acl')->getData();
        $this->aclManager
            ->setObjectPermissions(ObjectIdentity::fromDomainObject($category), $acl);
        
        
    }
}