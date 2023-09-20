<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Entity\Good as GoodEntity;
use App\Service\Remote\Good as RemoteGoodDTO;

class GoodAdapter
{
    public static function goodRemoteToEntity(RemoteGoodDTO $remoteGood): GoodEntity
    {
        $good = new GoodEntity();

        $good->setName($remoteGood->title);
        $good->setPrice($remoteGood->price);
        $good->setDescription($remoteGood->description);

        return $good;
    }
}
