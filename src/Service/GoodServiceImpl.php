<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\GoodForCreate;
use App\DTO\GoodForUpdate;
use App\Entity\Good;
use App\Exception\NotFoundException;
use App\Repository\GoodRepository;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\NonUniqueResultException;

class GoodServiceImpl implements GoodService
{
    public function __construct(private readonly GoodRepository $goodRepository,
                                private readonly FileService    $fileService)
    {
    }

    public function create(GoodForCreate $dto): void
    {
        $good = new Good();
        $good->setName($dto->name);
        $good->setPrice($dto->price);
        $good->setDescription($dto->description);

        $savedPath = $this->fileService->upload($dto->photo);
        $good->setPhoto($savedPath);

        $this->goodRepository->save($good);
    }

    /**
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    public function update(GoodForUpdate $dto): void
    {
        $good = $this->goodRepository->one($dto->id);
        if (!$good) throw new NotFoundException('good is not found');

        if ($dto->photo) {
            $savedPath = $this->fileService->upload($dto->photo);
            $this->fileService->delete($good->getPhoto());
            $good->setPhoto($savedPath);
        }

        $good->setName($dto->name);
        $good->setPrice($dto->price);
        $good->setDescription($dto->description);

        $this->goodRepository->save($good);
    }

    /**
     * @throws NotFoundException
     * @throws NonUniqueResultException
     */
    public function one(int $id): Good
    {
        $good = $this->goodRepository->one($id);
        if (!$good) throw new NotFoundException('good is not found');

        return $good;
    }

    /**
     * @throws Exception
     */
    public function delete(int $id): void
    {
        $good = $this->goodRepository->find($id);
        if (!$good) return;

        $this->goodRepository->delete($id);
    }

    /** @return array []Good */
    public function list(): array
    {
        return $this->goodRepository->list();
    }
}