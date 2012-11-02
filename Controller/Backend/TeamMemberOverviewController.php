<?php
namespace Neutron\Plugin\TeamMemberBundle\Controller\Backend;

use Neutron\SeoBundle\Model\SeoAwareInterface;

use Neutron\Plugin\TeamMemberBundle\TeamMemberPlugin;

use Neutron\MvcBundle\Provider\PluginProvider;

use Neutron\SeoBundle\Model\SeoInterface;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberOverviewInterface;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Neutron\MvcBundle\Model\Category\CategoryInterface;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DependencyInjection\ContainerAware;

class TeamMemberOverviewController extends ContainerAware
{
    public function updateAction($id)
    {
        $form = $this->container->get('neutron_team_member.form.team_member_overview');
        $handler = $this->container->get('neutron_team_member.form.handler.team_member_overview');
        
        $form->setData($this->getData($id));
    
        if (null !== $handler->process()){
            return new Response(json_encode($handler->getResult()));
        }
    
        $template = $this->container->get('templating')->render(
            'NeutronTeamMemberBundle:Backend\TeamMemberOverview:update.html.twig', array(
                'form' => $form->createView(),
                'plugin' => $this->container->get('neutron_mvc.plugin_provider')->get(TeamMemberPlugin::IDENTIFIER),
                'translationDomain' =>  $this->container
                    ->getParameter('neutron_team_member.translation_domain')
            )
        );
    
        return  new Response($template);
    }
    
    public function deleteAction($id)
    {
        $category = $this->getCategory($id);
        $teamMemberOverview = $this->getTeamMemberOverview($category);
    
        if ($this->container->get('request')->getMethod() == 'POST'){
            $this->doDelete($teamMemberOverview);
            $redirectUrl = $this->container->get('router')->generate('neutron_mvc.category.management');
            return new RedirectResponse($redirectUrl);
        }
    
        $template = $this->container->get('templating')->render(
            'NeutronTeamMemberBundle:Backend\TeamMemberOverview:delete.html.twig', array(
                'entity' => $teamMemberOverview,
                'plugin' => $this->container->get('neutron_mvc.plugin_provider')->get(TeamMemberPlugin::IDENTIFIER),
                'translationDomain' =>  $this->container
                    ->getParameter('neutron_team_member.translation_domain')
            )
        );
    
        return  new Response($template);
    }
    
    protected function doDelete(TeamMemberOverviewInterface $teamMemberOverview)
    {
        $this->container->get('neutron_admin.acl.manager')
            ->deleteObjectPermissions(ObjectIdentity::fromDomainObject($teamMemberOverview->getCategory()));
    
        $this->container->get('neutron_team_member.team_member_overview_manager')
            ->delete($teamMemberOverview, true);
    }
    
    protected function getCategory($id)
    {
        $treeManager = $this->container->get('neutron_tree.manager.factory')
            ->getManagerForClass($this->container->getParameter('neutron_mvc.category.category_class'));
    
        $category = $treeManager->findNodeBy(array('id' => $id));
    
        if (!$category){
            throw new NotFoundHttpException();
        }
    
        return $category;
    }
    
    protected function getTeamMemberOverview(CategoryInterface $category)
    {
        $teamMemberOverview = $this->container->get('neutron_team_member.team_member_overview_manager')
            ->findOneBy(array('category' => $category));
    
        if (!$teamMemberOverview){
            throw new NotFoundHttpException();
        }
    
        return $teamMemberOverview;
    }
    
    protected function getSeo(SeoAwareInterface $teamMemberOverview)
    {
    
        if(!$teamMemberOverview->getSeo() instanceof SeoInterface){
            $manager = $this->container->get('neutron_seo.manager');
            $seo = $manager->createSeo();
            $teamMemberOverview->setSeo($seo);
        }
    
        return $teamMemberOverview->getSeo();
    }
    
    protected function getData($id)
    {
        $category = $this->getCategory($id);
        $teamMemberOverview = $this->getTeamMemberOverview($category);
        $seo = $this->getSeo($teamMemberOverview);

        return array(
            'general' => $category,
            'content' => $teamMemberOverview,
            'seo'     => $seo,

            'acl' => $this->container->get('neutron_admin.acl.manager')
                ->getPermissions(ObjectIdentity::fromDomainObject($category))
        );
    }
}