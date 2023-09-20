<?php

declare(strict_types=1);

namespace App\Service;

interface FileRemoteServiceInterface
{
    public function uploadFromURL(string $url): string;
}