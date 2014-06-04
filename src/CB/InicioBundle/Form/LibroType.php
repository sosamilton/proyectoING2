<?php

namespace CB\InicioBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class LibroType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre')
            ->add('imagen')
            ->add('descripcion')
            ->add('anio')
            ->add('idioma')
            ->add('precio')
            ->add('borrado')
            ->add('editorial')
            ->add('autor')
            ->add('categoria')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CB\InicioBundle\Entity\Libro'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'cb_iniciobundle_libro';
    }
}
