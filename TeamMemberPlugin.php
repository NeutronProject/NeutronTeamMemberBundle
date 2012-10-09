<?php
namespace Neutron\Plugin\TeamMemberBundle;

use Neutron\MvcBundle\Plugin\PluginInterface;

use Neutron\MvcBundle\Model\MvcManagerInterface;

use Neutron\MvcBundle\MvcEvents;

use Neutron\MvcBundle\Event\ConfigurePluginEvent;

use Symfony\Component\Translation\TranslatorInterface;

use Symfony\Component\Routing\RouterInterface;

use Neutron\MvcBundle\Plugin\PluginFactoryInterface;

use Symfony\Component\EventDispatcher\EventDispatcher;

class TeamMemberPlugin
{
    const IDENTIFIER = 'neutron.plugin.team_member';
    
    const ITEM_IDENTIFIER = 'neutron.plugin.team_member.item';
    
    protected $dispatcher;
    
    protected $factory;
    
    protected $router;
    
    protected $translator;
    
    protected $mvcManager;
    
    protected $translationDomain;
    
    public function __construct(EventDispatcher $dispatcher, PluginFactoryInterface $factory, RouterInterface $router, 
            TranslatorInterface $translator, MvcManagerInterface $mvcManager, $translationDomain)
    {
        $this->dispatcher = $dispatcher;
        $this->factory = $factory;
        $this->router = $router;
        $this->translator = $translator;
        $this->manager = $mvcManager;
        $this->translationDomain = $translationDomain;
        
    }
    
    public function build()
    {
        $plugin = $this->factory->createPlugin(self::IDENTIFIER);
        $plugin
            ->setLabel($this->translator->trans('plugin.team_member.label', array(), $this->translationDomain))
            ->setDescription($this->translator->trans('plugin.team_member.description', array(),$this->translationDomain))
            ->setFrontController('neutron_team_member.controller.frontend.team_member_overview:indexAction')
            ->setAdministrationRoute('neutron_team_member.backend.team_member')
            ->setUpdateRoute('neutron_team_member.backend.team_member_overview.update')
            ->setDeleteRoute('neutron_team_member.backend.team_member_overview.delete')
            ->setMvcManager($this->mvcManager)
            ->setTreeOptions(array(
                'children_strategy' => PluginInterface::CHILDREN_STRATEGY_SELF,
            ))
        ;
        
        $this->dispatcher->dispatch(
            MvcEvents::onPluginConfigure, 
            new ConfigurePluginEvent($this->factory, $plugin)
        );
        
        return $plugin;
    }
    
}