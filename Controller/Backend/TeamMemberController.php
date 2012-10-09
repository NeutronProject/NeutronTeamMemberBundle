<?php
namespace Neutron\Plugin\TeamMemberBundle\Controller\Backend;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Neutron\Plugin\TeamMemberBundle\TeamMemberPlugin;

use Symfony\Component\BrowserKit\Response;

use Symfony\Component\DependencyInjection\ContainerAware;

class TeamMemberController extends ContainerAware
{
    public function indexAction()
    {
        $grid = $this->container->get('neutron.datagrid')
            ->get($this->container->getParameter('neutron_team_member.datagrid.team_member_management'));
    
        $template = $this->container->get('templating')->render(
            'NeutronCustomerServicesBundle:Backend\Administration:index.html.twig', array(
                'grid' => $grid,
                'translationDomain' =>
                    $this->container->getParameter('neutron_team_member.translation_domain')
            )
        );
    
        return  new Response($template);
    }
    
    public function updateAction($id)
    {
        $form = $this->container->get('neutron_team_member.form.team_member');
        $handler = $this->container->get('neutron_team_member.form.handler.team_member');
        $form->setData($this->getData($id));
    
        if (null !== $handler->process()){
            return new Response(json_encode($handler->getResult()));
        }
    
        $template = $this->container->get('templating')->render(
            'NeutronTeamMemberBundle:Backend\TeamMember:update.html.twig', array(
                'form' => $form->createView(),
                'plugin' => $this->container->get('neutron_mvc.plugin_provider')->get(TeamMemberPlugin::IDENTIFIER),
                'translationDomain' =>
                    $this->container->getParameter('neutron_team_member.translation_domain')
            )
        );
    
        return  new Response($template);
    }
    
    public function deleteAction($id)
    {
        $teamMember = $this->getTeamMember($id);
    
        if ($this->container->get('request')->getMethod() == 'POST'){
            $this->container->get('neutron_team_member.team_member_manager')->delete($teamMember, true);
            $redirectUrl = $this->container->get('router')->generate('neutron_team_member.backend.team_member');
            return new RedirectResponse($redirectUrl);
        }
    
        $template = $this->container->get('templating')->render(
            'NeutronTeamMemberBundle:Backend\TeamMember:delete.html.twig', array(
                'entity' => $teamMember,
                'plugin' => $this->container->get('neutron_mvc.plugin_provider')->get(TeamMemberPlugin::IDENTIFIER),
                'translationDomain' =>
                    $this->container->getParameter('neutron_team_member.translation_domain')
            )
        );
    
        return  new Response($template);
    }
    
    protected function getTeamMember($id)
    {
        $teamMemberManager = $this->container->get('neutron_team_member.team_member_manager');
    
        if ($id){
            $teamMember = $teamMemberManager->findOneBy(array('id' => $id));
        } else {
            $teamMember = $teamMemberManager->create();
        }
    
        if (!$teamMember){
            throw new NotFoundHttpException();
        }
    
        return $teamMember;
    }
    
    protected function getData($id)
    {
        $teamMember = $this->getTeamMember($id);
  
        return array('content' => $teamMember);
    }
}