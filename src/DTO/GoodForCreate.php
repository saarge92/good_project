<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

class GoodForCreate
{
    public string $name;

    public float $price;

    public UploadedFile $photo;

    public ?string $description = "";
}