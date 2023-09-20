<?php

declare(strict_types=1);

namespace App\Service;

class FileRemoteService implements FileRemoteServiceInterface
{
    public function __construct(private readonly string $publicPath)
    {
    }

    public function uploadFromURL(string $url): string
    {
        $pathInfo = pathinfo($url);
        $fileContent = file_get_contents($url);

        $newName = $pathInfo['filename'] . '-' . uniqid() . '.' . $pathInfo['extension'];
        $savePath = $this->publicPath . FileServiceInterfaceImpl::UPLOADS_PATH;

        $filePath = $savePath . $newName;
        file_put_contents($filePath, $fileContent);

        return FileServiceInterfaceImpl::UPLOADS_PATH . $newName;
    }
}
