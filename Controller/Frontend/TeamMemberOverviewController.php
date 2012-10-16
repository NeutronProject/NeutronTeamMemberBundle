<?php
namespace Neutron\Plugin\TeamMemberBundle\Controller\Frontend;

use Neutron\MvcBundle\Model\Category\CategoryInterface;

use Symfony\Component\HttpFoundation\Response;

use Neutron\Plugin\TeamMemberBundle\TeamMemberPlugin;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\DependencyInjection\ContainerAware;

class TeamMemberOverviewController extends ContainerAware
{
    public function indexAction(CategoryInterface $category)
    {
        $plugin = $this->container->get('neutron_mvc.plugin_provider')->get(TeamMemberPlugin::IDENTIFIER);
        $mvcManager = $this->container->get('neutron_mvc.mvc_manager');
        $teamMemberOverviewManager = $this->container->get('neutron_team_member.team_member_overview_manager');
        $overview = $teamMemberOverviewManager->getByCategory($category);

    
        if (null === $overview){
            throw new NotFoundHttpException();
        }
    
        $mvcManager->loadPanels($plugin, $overview->getId(), TeamMemberPlugin::IDENTIFIER);
         
        $template = $this->container->get('templating')->render($overview->getTemplate(), array(
            'entity'   => $overview,
            'plugin' => $plugin,
        ));
    
        return  new Response($template);
    }
}