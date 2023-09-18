<?php

declare(strict_types=1);

namespace App\Service;

interface FileRemoteService
{
    public function uploadFromURL(string $url): string;
}