<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class GoodForCreate
{
    public string $name;

    public float $price;

    public UploadedFile $photo;

    public ?string $description = "";
}
