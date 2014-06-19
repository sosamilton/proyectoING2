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
            ->add('nombre', 'text', array(
                'label' => 'Nombre'
            ))
            ->add('imagen', 'text', array(
                'label' => 'Imagen'
            ))
            ->add('descripcion', 'textarea', array(
                'label' => 'Descripcion'
            ))
            ->add('anio', 'text', array(
                'label' => 'Año'
            ))
            ->add('idioma', 'text',array(
                'label' => 'Idioma'
            ))
            ->add('precio', 'text', array(
                'label' => 'Precio'
            ))
            ->add('borrado', 'hidden')
                
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
