<?php
/*
 * This file is part of NeutronTeamMemberBundle
 *
 * (c) Nikolay Georgiev <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Plugin\TeamMemberBundle\Entity\Repository;

use Gedmo\Translatable\Entity\Repository\TranslationRepository;

class TeamMemberRepository extends TranslationRepository
{
    public function getQueryBuilderForTeamMemberManagementDataGrid()
    {
        $qb = $this->createQueryBuilder('m');
        return $qb;
    }
    
    public function getQueryBuilderForTeamMemberFormDataGrid()
    {
        $qb = $this->createQueryBuilder('m');
        $qb->where('m.enabled = ?1');
        $qb->setParameters(array(1 => true));
        return $qb;
    }
}