<?php
namespace Neutron\Plugin\TeamMemberBundle\Doctrine;

use Neutron\MvcBundle\Model\Category\CategoryInterface;

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberOverviewManagerInterface;

use Neutron\ComponentBundle\Doctrine\AbstractManager;

class TeamMemberOverviewManager extends AbstractManager implements TeamMemberOverviewManagerInterface
{
    public function getByCategory(CategoryInterface $category)
    {
        return $this->repository->getByCategory($category);
    }
}
