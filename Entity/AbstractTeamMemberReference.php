<?php
/*
 * This file is part of NeutronTeamMemberBundle
 *
 * (c) Nikolay Georgiev <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Plugin\TeamMemberBundle\Entity;

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberOverviewInterface;

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberInterface;

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberReferenceInterface;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class AbstractTeamMemberReference implements TeamMemberReferenceInterface
{
    /**
     * @var integer 
     *
     * @ORM\Id @ORM\Column(name="id", type="integer")
     * 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @var integer
     *
     * @ORM\Column(type="integer", name="position", length=10, nullable=true, unique=false)
     */
    protected $position = 0;
    
    /**
     * @ORM\ManyToOne(targetEntity="Neutron\Plugin\TeamMemberBundle\Model\TeamMemberInterface")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */   
    protected $inversed;
    
    /**
     * @ORM\ManyToOne(targetEntity="Neutron\Plugin\TeamMemberBundle\Model\TeamMemberOverviewInterface", inversedBy="references")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */   
    protected $teamMemberOverview;
    

    public function getId ()
    {
        return $this->id;
    }
    
	public function getPosition ()
    {
        return $this->position;
    }

	public function setPosition ($position)
    {
        $this->position = $position;
    }

	public function getInversed ()
    {
        return $this->inversed;
    }

	public function setInversed ($inversed)
    {
        if (!$inversed instanceof TeamMemberInterface){
            throw new \InvalidArgumentException('Reference must be instance of TeamMemberInterface');
        }
        
        $this->inversed = $inversed;
    }

	public function getTeamMemberOverview ()
    {
        return $this->teamMemberOverview;
    }

	public function setTeamMemberOverview (TeamMemberOverviewInterface $teamMemberOverview)
    {
        $this->teamMemberOverview = $teamMemberOverview;
    }
    
    public function getLabel()
    {
        return $this->inversed->getName();
    }
  
}