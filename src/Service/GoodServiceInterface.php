<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\GoodForCreate;
use App\DTO\GoodForUpdate;
use App\Entity\Good;

interface GoodServiceInterface
{
    public function create(GoodForCreate $dto): int;

    public function update(GoodForUpdate $dto): void;

    public function one(int $id): Good;

    public function delete(int $id): void;

    /** @return array []Good */
    public function list(): array;
}
