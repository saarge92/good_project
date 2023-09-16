<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileServiceImpl implements FileService
{
    public function __construct(
        private readonly SluggerInterface $slugger,
        private readonly string $uploadFileDirectory,
        private readonly FileSystem $fileSystem,
    )
    {
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->guessExtension();

        $file->move($this->uploadFileDirectory, $newFilename);

        return $this->uploadFileDirectory . $newFilename;
    }

    public function delete(string $path): void
    {
        $this->fileSystem->remove($path);
    }
}