<?php

declare(strict_types=1);

namespace App\Adapter;

use App\Entity\Good as GoodEntity;
use App\Service\Remote\Good as RemoteGoodDTO;

class GoodAdapter
{
    public static function goodRemoteToEntity(RemoteGoodDTO $dnsGood): GoodEntity
    {
        $good = new GoodEntity();

        $good->setName($dnsGood->title);
        $good->setPrice($dnsGood->price);
        $good->setDescription($dnsGood->description);

        return new GoodEntity();
    }
}