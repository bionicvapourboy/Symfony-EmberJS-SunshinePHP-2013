<?php

namespace SunshinePHP\Bundle\TodoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TodoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('done', 'checkbox', array('required' => false))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SunshinePHP\Bundle\TodoBundle\Entity\Todo'
        ));
    }

    public function getName()
    {
        return 'sunshinephp_bundle_todobundle_todotype';
    }
}
