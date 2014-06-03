<?php

namespace CB\InicioBundle\Form;

use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;

class RegistrationFormType extends BaseType
{
    public function buildForm(FormBuilder $builder, array $options)     {
        parent::buildForm($builder, $options);

        $builder->add('roles', 'choice', array('label' => 'Rol', 'required' => true, 'choices' => array( 1 => 'ROLE_ADMIN', 2 => 'ROLE_USER'), 'multiple' => true));

    }

    public function getName() {
        return 'mi_user_registration';
    }
}