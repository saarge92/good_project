<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileServiceInterface
{
    public function upload(UploadedFile $file): string;

    public function delete(string $path): void;
}