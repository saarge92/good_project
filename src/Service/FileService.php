<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;

class FileService implements FileServiceInterface
{
    public const UPLOADS_PATH = "uploads/";

    public function __construct(
        private readonly SluggerInterface $slugger,
        private readonly string $publicPath,
        private readonly FileSystem $fileSystem,
    ) {
    }

    public function upload(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->slugger->slug($originalFilename);
        $newFilename = $safeFilename . '-' . uniqid() . '.' . $file->getClientOriginalExtension();

        $savePath = $this->publicPath . self::UPLOADS_PATH;
        $file->move($savePath, $newFilename);

        return self::UPLOADS_PATH . $newFilename;
    }

    public function delete(string $path): void
    {
        $this->fileSystem->remove($path);
    }
}
