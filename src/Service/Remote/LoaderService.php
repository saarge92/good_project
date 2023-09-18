<?php

declare(strict_types=1);

namespace App\Service\Remote;

use  App\Entity\Good as GoodEntity;

interface LoaderService
{
    public function loadAndSave(string $url): GoodEntity;
}