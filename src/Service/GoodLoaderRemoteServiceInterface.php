<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Good as GoodEntity;

interface GoodLoaderRemoteServiceInterface
{
    public function loadAndSave(string $url): GoodEntity;
}