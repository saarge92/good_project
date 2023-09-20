<?php

declare(strict_types=1);

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class UpdateGoodType extends AbstractType
{
    // phpcs:ignore
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 3, 'max' => 30])
                ]
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('photo', FileType::class, [
                'required' => false,
                'multiple' => false,
                'attr' => array(
                    'accept' => 'image/*',
                ),
                'constraints' => [
                    new Image(['maxSize' => '10m'])
                ]
            ])
            ->add(
                'description',
                TextType::class,
                [
                    'required' => false,
                    'constraints' => [
                        new Length(['min' => 3, 'max' => 120])
                    ]
                ]
            )
            ->add('save', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'csrf_protection' => true,
            'allow_extra_fields' => true,
        ]);
    }
}
