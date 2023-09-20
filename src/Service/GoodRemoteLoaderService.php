<?php

declare(strict_types=1);

namespace App\Service;

use App\Adapter\GoodAdapter;
use App\Entity\Good as GoodEntity;
use App\Repository\GoodRepository;
use App\Service\Remote\ClientInterface;

class GoodRemoteLoaderService implements GoodLoaderRemoteServiceInterface
{
    public function __construct(private readonly ClientInterface            $client,
                                private readonly FileRemoteServiceInterface $fileRemoteService,
                                private readonly GoodRepository             $goodRepository)
    {
    }

    public function loadAndSave(string $url): GoodEntity
    {
        $goodDto = $this->client->get($url);
        $good = GoodAdapter::goodRemoteToEntity($goodDto);

        $savedPath = $this->fileRemoteService->uploadFromURL($goodDto->image);
        $good->setPhoto($savedPath);

        $this->goodRepository->save($good);

        return $good;
    }
}