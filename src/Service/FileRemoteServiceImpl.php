<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Component\Filesystem\Filesystem;

class FileRemoteServiceImpl implements FileRemoteService
{

    public function __construct(private readonly FileSystem $fileSystem){}
    public function uploadFromURL(string $url): string
    {
        $parsedUrl = parse_url($url);
        $pathInfo = pathinfo($parsedUrl);

        return "";
    }
}