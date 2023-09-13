<?php

declare(strict_types=1);

namespace App\Service;

use App\DTO\GoodForCreate;
use App\DTO\GoodForUpdate;
use App\Entity\Good;
use App\Exception\NotFoundException;
use App\Repository\GoodRepository;
use Doctrine\DBAL\Exception;

class GoodServiceImpl implements GoodService
{
    public function __construct(private readonly GoodRepository $goodRepository){}
    public function create(GoodForCreate $dto): void
    {
        $good = new Good();
        $good->setName($dto->name);
        $good->setPrice($dto->price);
        $good->setDescription($dto->description);

        // todo save uploaded file using service
        // $good->setPhoto()

        $this->goodRepository->save($good);
    }

    /**
     * @throws NotFoundException
     */
    public function update(GoodForUpdate $dto): void
    {
        $good = $this->goodRepository->find($dto->id);
        if (!$good) throw new NotFoundException('good is not found');

        // todo check if uploaded file is empty -> then save uploaded file & delete previous
        $good->setName($dto->name);
        $good->setPrice($dto->price);
        $good->setDescription($dto->description);

        $this->goodRepository->save($good);
    }

    /**
     * @throws NotFoundException
     */
    public function get(int $id): Good
    {
        $good = $this->goodRepository->find($id);
        if (!$good) throw new NotFoundException('good is not found');

        return $good;
    }
    
    public function delete(int $id): void
    {
        $good = $this->goodRepository->find($id);
        if (!$good) return;

        // todo delete file

        $this->goodRepository->delete($id);
    }
}