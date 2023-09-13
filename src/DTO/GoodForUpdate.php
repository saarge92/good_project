<?php

declare(strict_types=1);

namespace App\DTO;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class GoodForUpdate extends GoodForCreate
{
    public int $id;

    public function __construct(
        int          $id,
        string       $name,
        float        $price,
        UploadedFile $file,
        string       $description)
    {
        parent::__construct($name, $price, $file, $description);
        $this->id = $id;
    }
}