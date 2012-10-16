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

use Neutron\SeoBundle\Model\SeoInterface;

use Neutron\SeoBundle\Model\SeoAwareInterface;

use Neutron\MvcBundle\Model\CategoryAwareInterface;

use Neutron\Bundle\FormBundle\Model\MultiSelectSortableReferenceInterface;

use Neutron\MvcBundle\Model\Category\CategoryInterface;

use Neutron\Plugin\TeamMemberBundle\TeamMemberPlugin;

use Doctrine\Common\Collections\ArrayCollection;

use Neutron\Bundle\FormBundle\Model\MultiSelectSortableInterface;

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberOverviewInterface;
 
use Doctrine\ORM\Mapping as ORM;
 
/**
 * @ORM\MappedSuperclass
 * 
 */
class AbstractTeamMemberOverview 
     implements TeamMemberOverviewInterface, CategoryAwareInterface, SeoAwareInterface, MultiSelectSortableInterface
{
    /**
     * @var integer 
     *
     * @ORM\Id @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
    * @var string
    *
    * @ORM\Column(type="string", name="template", length=255, nullable=true, unique=false)
    */
    protected $template;
    
    /**
     * @ORM\OneToMany(targetEntity="Neutron\Plugin\TeamMemberBundle\Model\TeamMemberReferenceInterface", mappedBy="teamMemberOverview", cascade={"all"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $references;
    
    /**
     * @ORM\OneToOne(targetEntity="Neutron\MvcBundle\Model\Category\CategoryInterface", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $category;
    
    /**
     * @ORM\OneToOne(targetEntity="Neutron\SeoBundle\Entity\Seo", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $seo;
    
    public function __construct()
    {
        $this->references = new ArrayCollection();
    }
    
    public function getId()
    {
        return $this->id;
    }
    
    public function setTemplate($template)
    {
     $this->template = $template;
    }
    
    public function getTemplate()
    {
        return $this->template;
    }
    
    public function setCategory(CategoryInterface $category)
    {
        $this->category = $category;
        return $this;
    }
    
    public function getCategory()
    {
        return $this->category;
    }
    
    public function setSeo(SeoInterface $seo)
    {
        $this->seo = $seo;
        return $this;
    }
    
    public function getSeo()
    {
        return $this->seo;
    }
    
    public function getIdentifier()
    {
        return TeamMemberPlugin::IDENTIFIER;
    }
    
    public function getReferences()
    {
        return $this->references;
    }
    
    public function addReference(MultiSelectSortableReferenceInterface $reference)
    {
     if (!$this->references->contains($reference)){
        $this->references->add($reference);
        $reference->setTeamMemberOverview($this);
     }
    
        return $this;
    }
    
    public function removeReference(MultiSelectSortableReferenceInterface $reference)
    {
        if ($this->references->contains($reference)){
            $this->references->removeElement($reference);
        }
    
        return $this;
    }
}