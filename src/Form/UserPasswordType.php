<?php

namespace App\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class UserPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'label' => 'Password',
                    'label_attr' => [
                        'class' => 'form-label'
                    ],
                ],
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control',
                    ],
                    'label' => 'Confirm Password',
                    'label_attr' => [
                        'class' => 'form-label'
                    ],
                ],
                'invalid_message' => 'The password fields must match.',
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 6])
                ]
            ])
            ->add('newPassword', PasswordType::class, [
                'attr' => ['class' => 'form-control',],
                'label' => 'New Password',
                'label_attr' => ['class' => 'form-label mt-4'],
                 'constraints' => [new Assert\NotBlank()]
        ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
            ]);
    }
}
