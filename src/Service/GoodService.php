<?php

declare(strict_types=1);

namespace App\Service;
use App\DTO\GoodForCreate;
use App\DTO\GoodForUpdate;

interface GoodService
{
    public function create(GoodForCreate $dto): void;

    public function update(GoodForUpdate $dto): void;
}