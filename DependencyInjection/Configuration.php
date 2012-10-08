<?php

namespace Neutron\Plugin\TeamMemberBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

class Configuration implements ConfigurationInterface
{

    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('neutron_team_member');

        return $treeBuilder;
    }
    
    private function addGeneralConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enable')->defaultFalse()->end()
                ->scalarNode('overview_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('team_member_reference_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('overview_manager')->defaultValue('neutron_team_member.doctrine.orm.overview_manager.default')->end()
                ->scalarNode('overview_controller_backend')->defaultValue('neutron_team_member.controller.backend.overview.default')->end()
                ->scalarNode('overview_controller_frontend')->defaultValue('neutron_team_member.controller.frontend.overview.default')->end()
                ->scalarNode('team_member_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('team_member_manager')->defaultValue('neutron_team_member.doctrine.orm.team_member_manager.default')->end()
                ->scalarNode('team_member_controller_backend')->defaultValue('neutron_team_member.controller.backend.team_member.default')->end()
                ->scalarNode('team_member_controller_frontend')->defaultValue('neutron_team_member.controller.frontend.team_member.default')->end()
                ->scalarNode('team_member_datagrid_management')->defaultValue('team_member_management')->end()
                ->scalarNode('translation_domain')->defaultValue('NeutronTeamMemberBundle')->end()
            ->end()
        ;
    }
    
    private function addOverviewFormConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                 ->arrayNode('overview_form')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('type')->defaultValue('neutron_team_member_overview')->end()
                            ->scalarNode('handler')->defaultValue('neutron_team_member.form.handler.overview.default')->end()
                            ->scalarNode('name')->defaultValue('neutron_team_member_overview')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
    
    private function addOverviewTemplatesConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('overview_templates')->isRequired()
                ->validate()
                    ->ifTrue(function($v){return empty($v);})
                    ->thenInvalid('You should provide at least one template.')
                ->end()
                ->useAttributeAsKey('name')
                    ->prototype('scalar')
                ->end() 
                ->cannotBeOverwritten()
                ->isRequired()
                ->cannotBeEmpty()
            ->end()
        ;
    }
    
    private function addTeamMemberFormConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                 ->arrayNode('team_member_form')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('type')->defaultValue('neutron_team_member')->end()
                            ->scalarNode('handler')->defaultValue('neutron_team_member.form.handler.team_member.default')->end()
                            ->scalarNode('name')->defaultValue('neutron_team_member')->end()
                            ->scalarNode('datagrid')->defaultValue('neutron_team_member_form')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

}
