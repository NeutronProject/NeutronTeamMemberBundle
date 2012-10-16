<?php
/*
 * This file is part of NeutronTeamMemberBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Plugin\TeamMemberBundle\Entity\Repository;

use Neutron\MvcBundle\Model\Category\CategoryInterface;

use Gedmo\Translatable\Entity\Repository\TranslationRepository;

class TeamMemberOverviewRepository extends TranslationRepository
{
    public function getByCategoryQueryBuilder(CategoryInterface $category)
    {
        $qb = $this->createQueryBuilder('o');
        $qb
            ->select('o, r, m')
            ->join('o.references', 'r')
            ->join('r.inversed', 'm')
            ->where('o.category = ?1 AND m.enabled = ?2')
            ->orderBy('r.position', 'ASC')
            ->setParameters(array(1 => $category, 2 => true))
        ;
        
        return $qb;
    }
    
    public function getByCategoryQuery(CategoryInterface $category)
    {
        $query = $this->getByCategoryQueryBuilder($category)->getQuery();
        
        return $query;
    }
    
    public function getByCategory(CategoryInterface $category)
    {
        return $this->getByCategoryQuery($category)->getOneOrNullResult();
    }
}