<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Entity\Good as GoodEntity;
use App\Service\FileRemoteService;
use App\Service\FileRemoteServiceInterface;
use App\Service\GoodLoaderRemoteServiceInterface;
use App\Service\Remote\Client;
use App\Service\Remote\ClientInterface;
use App\Service\Remote\Good as GoodRemote;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GoodRemoteLoaderServiceTest extends WebTestCase
{
    protected function setUp(): void
    {
        self::bootKernel();
    }

    /**
     * @throws Exception
     */
    public function testUpload(): void
    {
        $container = self::getContainer();

        $url = "url";
        $clientMock = $this->getMockBuilder(Client::class)
            ->disableOriginalConstructor()->onlyMethods(['get'])
            ->getMock();
        $container->set(ClientInterface::class, $clientMock);

        $fileRemoteServiceMock = $this->getMockBuilder(FileRemoteService::class)
            ->disableOriginalConstructor()->onlyMethods(['uploadFromURL'])
            ->getMock();
        $container->set(FileRemoteServiceInterface::class, $fileRemoteServiceMock);

        $goodRemoteExpected = $this->createGoodRemoteMock();
        $imageFileExpected = 'image_path';

        $clientMock->method('get')->willReturn($goodRemoteExpected);
        $fileRemoteServiceMock->method('uploadFromURL')
            ->with($goodRemoteExpected->image)->willReturn($imageFileExpected);

        $service = $container->get(GoodLoaderRemoteServiceInterface::class);
        $goodEntity = $service->loadAndSave($url);

        $this->assertGoodCreatedProperly($goodEntity, $goodRemoteExpected);
    }

    private function assertGoodCreatedProperly(GoodEntity $goodEntity, GoodRemote $goodRemote): void
    {
        $this->assertEquals($goodRemote->description, $goodEntity->getDescription());
        $this->assertEquals($goodRemote->title, $goodEntity->getName());
        $this->assertEquals($goodRemote->price, $goodEntity->getPrice());
    }

    private function createGoodRemoteMock(): GoodRemote
    {
        $goodRemote = new GoodRemote();

        $goodRemote->title = "new_title";
        $goodRemote->description = "new_description";
        $goodRemote->price = 2.25;
        $goodRemote->image = "image_path";

        return $goodRemote;
    }
}
