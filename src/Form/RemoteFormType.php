<?php

declare(strict_types=1);

namespace App\Form;

use App\Form\Constraint\RemoteUrlConstraint;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;

class RemoteFormType extends AbstractType
{
    // phpcs:ignore
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('url', TextType::class, [
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new RemoteUrlConstraint()
                ]
            ])
            ->add('save', SubmitType::class);
        ;
    }
}
