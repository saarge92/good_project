<?php

declare(strict_types=1);

namespace App\Service;

class FileRemoteServiceImpl implements FileRemoteService
{
    public function __construct(private readonly string $publicPath){}
    public function uploadFromURL(string $url): string
    {
        $pathInfo = pathinfo($url);
        $fileContent = file_get_contents($url);

        $newName = $pathInfo['filename'] . '-' . uniqid() . '.' . $pathInfo['extension'];
        $savePath = $this->publicPath . FileServiceImpl::UPLOADS_PATH;

        $filePath = $savePath . $newName;
        file_put_contents($filePath, $fileContent);

        return FileServiceImpl::UPLOADS_PATH . $newName;
    }
}