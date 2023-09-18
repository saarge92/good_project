<?php

declare(strict_types=1);

namespace App\Form\Constraint;

use Symfony\Component\Validator\Constraint;

class RemoteUrlConstraint extends Constraint
{
    public string $message = 'The string is not dns-shop.ru URL address.';
    public function validatedBy(): string
    {
        return RemoteUrlConstraintValidator::class;
    }
}