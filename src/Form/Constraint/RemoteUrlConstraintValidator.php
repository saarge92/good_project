<?php

declare(strict_types=1);

namespace App\Form\Constraint;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

class RemoteUrlConstraintValidator extends ConstraintValidator
{
    private const SHOP_URL_TEMPLATE = "/^(www\.)*fakestoreapi\.com/";

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof RemoteUrlConstraint) {
            throw new UnexpectedTypeException($constraint, RemoteUrlConstraint::class);
        }

        $url = (string)$value;

        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            $this->context->addViolation('string {{ string }} is not url', ['string' => $url]);
        }

        $parsedUrlData = parse_url($url);

        if (!preg_match(self::SHOP_URL_TEMPLATE, strtolower($parsedUrlData['host']))) {
            $this->context->addViolation("url has not fakestoreapi domain");
        }

        if (preg_match("/^\/products\/\d+/", $parsedUrlData['path']) === FALSE) {
            $this->context->addViolation('route is not valid');
        }
    }
}