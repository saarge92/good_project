<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileService
{
    public function upload(UploadedFile $file): string;
}