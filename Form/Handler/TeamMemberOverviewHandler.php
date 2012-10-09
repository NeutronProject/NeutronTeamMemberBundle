<?php
namespace Neutron\Plugin\TeamMemberBundle\Form\Handler;

use Neutron\MvcBundle\Model\MvcManagerInterface;

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberOverviewManagerInterface;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

use Neutron\ComponentBundle\Form\Handler\AbstractFormHandler;

class TeamMemberOverviewHandler extends AbstractFormHandler
{
    protected $plugin;
    
    protected $mvcManager;
    
    protected $aclManager;
    
    public function setAclManager(AclManagerInterface $aclManager)
    {
        $this->aclManager = $aclManager;
        return $this;
    }
    
    public function setMvcManager(MvcManagerInterface $mvcManager)
    {
        $this->mvcManager = $mvcManager;
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
        
        $this->plugin->getManager()->update($overview);
        
        if (count($this->plugin->getPanels()) > 0){
            $panels = $this->form->get('panels')->getData();
            $this->mvcManager->updatePanels($overview->getId(), $panels);
        }
        
        $this->om->flush();
        
        $acl = $this->form->get('acl')->getData();
        $this->aclManager
            ->setObjectPermissions(ObjectIdentity::fromDomainObject($category), $acl);
        
        
    }
}