<?php
namespace Neutron\Plugin\TeamMemberBundle\Model;

interface TeamMemberInterface
{
    public function getId ();
    
    public function getName ();
    
    public function setName ($name);
    
    public function getJobTitle ();
    
    public function setJobTitle ($jobTitle);
    
    public function getPhone ();
    
    public function setPhone ($phone);
    
    public function getEnablePhone ();
    
    public function setEnablePhone ($enablePhone);
    
    public function getEmail ();
    
    public function setEmail ($email);
    
    public function getEnableEmail ();
    
    public function setEnableEmail ($enableEmail);
    
    public function getContent ();
    
    public function setContent ($content);
    
    public function getEnabled ();
    
    public function setEnabled ($enabled);
}
