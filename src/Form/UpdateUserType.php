<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UpdateUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'label' => 'Nombre',
                'attr' => array('class' => 'mb-4 form-control')
            ))
            ->add('surname', TextType::class, array(
                'label' => 'Apellidos',
                'attr' => array('class' => 'mb-4 form-control')
            ))
            ->add('phone', TextType::class, array(
                'label' => 'Telefono',
                'attr' => array('class' => 'mb-4 form-control')
            ))
            ->add('address', TextType::class, array(
                'label' => 'Dirección',
                'attr' => array('class' => 'mb-4 form-control')
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Actualizar',
                'attr' => array('class' => 'mb-4 btn btn-outline-dark')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
