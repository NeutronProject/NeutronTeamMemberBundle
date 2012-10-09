<?php
namespace Neutron\Plugin\TeamMemberBundle\Model;

use Neutron\MvcBundle\Model\Category\CategoryInterface;

interface TeamMemberOverviewManagerInterface
{
    public function getByCategory(CategoryInterface $category);
}
