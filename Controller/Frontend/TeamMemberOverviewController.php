<?php
namespace Neutron\Plugin\TeamMemberBundle\Controller\Frontend;

use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\DependencyInjection\ContainerAware;

class TeamMemberOverviewController extends ContainerAware
{
    public function indexAction($slug)
    {

        $categoryManager = $this->container->get('neutron_mvc.category.manager');
        
        $entity = $categoryManager->findOneByCategorySlug(
            $this->container->getParameter('neutron_team_member.team_member_overview_class'),
            $slug,
            $this->container->get('request')->getLocale()
        );
        
        if (null === $entity){
            throw new NotFoundHttpException();
        }
        
        if (false === $this->container->get('neutron_admin.acl.manager')->isGranted($entity->getCategory(), 'VIEW')){
            throw new AccessDeniedException();
        }
        
        $template = $this->container->get('templating')->render($entity->getTemplate(), array(
            'entity'   => $entity,
        ));
    
        return  new Response($template);
    }
}