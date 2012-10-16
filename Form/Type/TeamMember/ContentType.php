<?php
/*
 * This file is part of NeutronTeamMemberBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Plugin\TeamMemberBundle\Form\Type\TeamMember;

use Symfony\Component\Form\FormView;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

/**
 * Short description
 *
 * @author Zender <azazen09@gmail.com>
 * @since 1.0
 */
class ContentType extends AbstractType
{
    protected $teamMemberClass;
    
    protected $translationDomain;
    
    protected $allowedRoles = array('ROLE_SUPER_ADMIN');
    
    public function setTeamMemberClass($teamMemberClass)
    {
        $this->teamMemberClass = $teamMemberClass;
    }
    
    public function setTranslationDomain($translationDomain)
    {
        $this->translationDomain = $translationDomain;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array(
               'label' => 'form.name',
               'translation_domain' => $this->translationDomain
            ))
            ->add('jobTitle', 'text', array(
                'label' => 'form.jobTitle',
                'translation_domain' => $this->translationDomain
            ))
            ->add('phone', 'text', array(
                'label' => 'form.phone',
                'translation_domain' => $this->translationDomain
            ))
            ->add('enablePhone', 'checkbox', array(
                'label' => 'form.enablePhone', 
                'value' => 1,
                'required' => false,
                'attr' => array('class' => 'uniform'),
                'translation_domain' => $this->translationDomain
            ))
            ->add('email', 'email', array(
                'label' => 'form.email',
                'translation_domain' => $this->translationDomain
            ))
            ->add('enableEmail', 'checkbox', array(
                'label' => 'form.enableEmail', 
                'value' => 1,
                'required' => false,
                'attr' => array('class' => 'uniform'),
                'translation_domain' => $this->translationDomain
            ))
            ->add('content', 'neutron_tinymce', array(
                'label' => 'form.content',
                'security' => $this->allowedRoles,
                'translation_domain' => $this->translationDomain,
                'configs' => array(
                    'theme' => 'advanced', //simple
                    'skin'  => 'o2k7',
                    'skin_variant' => 'black',
                    //'width' => '60%',
                    'height' => 300,
                    'dialog_type' => 'modal',
                    'readOnly' => false,
                ),
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'form.enabled', 
                'value' => 1,
                'required' => false,
                'attr' => array('class' => 'uniform'),
                'translation_domain' => $this->translationDomain
            ))
                      
       ;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->teamMemberClass,
            'validation_groups' => function(FormInterface $form){
                $validationGroups = array('default');
                if ($form->getData()->getEnablePhone() === true){
                    array_push($validationGroups, 'phone_enabled');
                }
                
                if ($form->getData()->getEnableEmail() === true){
                    array_push($validationGroups, 'email_enabled');
                }

                return $validationGroups;
            },
        ));
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'neutron_team_member_content';
    }
}