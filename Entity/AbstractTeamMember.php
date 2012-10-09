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

use Neutron\Plugin\TeamMemberBundle\Model\TeamMemberInterface;

use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class AbstractTeamMember implements TeamMemberInterface
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
     * @var string 
     * 
     * @Gedmo\Translatable
     * @ORM\Column(type="string", name="name", length=255, nullable=true, unique=false)
     */
    protected $name;
    
    /**
     * @var string 
     *
     * @Gedmo\Translatable
     * @ORM\Column(type="string", name="job_title", length=255, nullable=true, unique=false)
     */
    protected $jobTitle;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="phone", length=255, nullable=true, unique=false)
     */
    protected $phone;
    
    /**
     * @var boolean 
     *
     * @ORM\Column(type="boolean", name="enable_phone")
     */
    protected $enablePhone = false;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="email", length=255, nullable=true, unique=false)
     */
    protected $email;
    
    /**
     * @var boolean
     *
     * @ORM\Column(type="boolean", name="enable_email")
     */
    protected $enableEmail = false;
    
    /**
     * @var string 
     *
     * @Gedmo\Translatable
     * @ORM\Column(type="text", name="content", nullable=true)
     */
    protected $content;
    
    /**
     * @var boolean 
     *
     * @ORM\Column(type="boolean", name="enabled")
     */
    protected $enabled = false;
    
    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    protected $locale;
    
    public function getId ()
    {
        return $this->id;
    }
    
	public function getName ()
    {
        return $this->name;
    }

	public function setName ($name)
    {
        $this->name = $name;
    }

	public function getJobTitle ()
    {
        return $this->jobTitle;
    }

	public function setJobTitle ($jobTitle)
    {
        $this->jobTitle = $jobTitle;
    }

	public function getPhone ()
    {
        return $this->phone;
    }

	public function setPhone ($phone)
    {
        $this->phone = $phone;
    }

	public function getEnablePhone ()
    {
        return $this->enablePhone;
    }

	public function setEnablePhone ($enablePhone)
    {
        $this->enablePhone = $enablePhone;
    }

	public function getEmail ()
    {
        return $this->email;
    }

	public function setEmail ($email)
    {
        $this->email = $email;
    }

	public function getEnableEmail ()
    {
        return $this->enableEmail;
    }

	public function setEnableEmail ($enableEmail)
    {
        $this->enableEmail = $enableEmail;
    }

	public function getContent ()
    {
        return $this->content;
    }

	public function setContent ($content)
    {
        $this->content = $content;
    }

	public function getEnabled ()
    {
        return $this->enabled;
    }

	public function setEnabled ($enabled)
    {
        $this->enabled = $enabled;
    }
    
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
 
}