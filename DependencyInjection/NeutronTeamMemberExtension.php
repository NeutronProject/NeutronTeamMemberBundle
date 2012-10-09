<?php

namespace Neutron\Plugin\TeamMemberBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class NeutronTeamMemberExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        
        if ($config['enable'] === false){
            $container->getDefinition('neutron_team_member.plugin')->clearTag('neutron.plugin');
            return;
        }
        
        foreach (array('overview', 'team_member') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }
        
        $this->loadTeamMemberOverviewConfigurations($config, $container);
        $this->loadTeamMemberConfigurations($config, $container);
        
        $container->setParameter('neutron_team_member.translation_domain', $config['translation_domain']);
           
    }
    
    protected function loadTeamMemberOverviewConfigurations(array $config, ContainerBuilder $container)
    {
        $container->setAlias('neutron_team_member.controller.backend.team_member_overview', $config['team_member_overview_controller_backend']);
        $container->setAlias('neutron_team_member.controller.frontend.team_member_overview', $config['team_member_overview_controller_frontend']);
        $container->setAlias('neutron_team_member.team_member_overview_manager', $config['team_member_overview_manager']);
        $container->setParameter('neutron_team_member.team_member_overview_templates', $config['team_member_overview_templates']);
        $container->setParameter('neutron_team_member.team_member_overview_class', $config['team_member_overview_class']);
        $container->setParameter('neutron_team_member.team_member_reference_class', $config['team_member_reference_class']);
        
        $container->setAlias('neutron_team_member.form.handler.team_member_overview', $config['team_member_overview_form']['handler']);
        $container->setParameter('neutron_team_member.form.type.team_member_overview', $config['team_member_overview_form']['type']);
        $container->setParameter('neutron_team_member.form.name.team_member_overview', $config['team_member_overview_form']['name']);
        $container->setParameter('neutron_team_member.form.datagrid.team_member_form', $config['team_member_overview_form']['datagrid']);
    }
    
    protected function loadTeamMemberConfigurations(array $config, ContainerBuilder $container)
    {
        $container->setParameter('neutron_team_member.team_member_class', $config['team_member_class']);
        $container->setAlias('neutron_team_member.controller.backend.team_member', $config['team_member_controller_backend']);
        $container->setAlias('neutron_team_member.team_member_manager', $config['team_member_manager']);
        $container->setParameter('neutron_team_member.datagrid.team_member_management', $config['team_member_datagrid_management']);
        
        $container->setAlias('neutron_team_member.form.handler.team_member', $config['team_member_form']['handler']);
        $container->setParameter('neutron_team_member.form.type.team_member', $config['team_member_form']['type']);
        $container->setParameter('neutron_team_member.form.name.team_member', $config['team_member_form']['name']);
        
    }
}
