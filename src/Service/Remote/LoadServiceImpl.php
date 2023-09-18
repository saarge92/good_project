<?php

declare(strict_types=1);

namespace App\Service\Remote;

use App\Adapter\GoodAdapter;
use App\Entity\Good as GoodEntity;
use App\Repository\GoodRepository;
use App\Service\FileRemoteService;
use App\Service\GoodService;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LoadServiceImpl implements LoaderService
{
    public function __construct(private readonly Client $client,
                                private readonly FileRemoteService $fileRemoteService,
                                private readonly GoodRepository $goodRepository)
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