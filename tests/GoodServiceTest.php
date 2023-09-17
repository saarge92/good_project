<?php

declare(strict_types=1);

namespace App\Tests;

use App\DTO\GoodForCreate;
use App\Repository\GoodRepository;
use App\Service\GoodServiceImpl;
use Doctrine\ORM\NonUniqueResultException;
use Faker\Factory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class GoodServiceTest extends WebTestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel([
           'environment' => 'test'
        ]);
    }

    /**
     * @throws \Exception
     */
    public function testCreate(): void
    {
        $container = self::getContainer();
        /** @var GoodServiceImpl $service */
        $service = $container->get(GoodServiceImpl::class);

        $dto = $this->initGoodForCreateDTO();
        $id = $service->create($dto);

        $this->assertGoodCreated($id, $container->get(GoodRepository::class));
    }

    private function initGoodForCreateDTO(): GoodForCreate
    {
        $imagePath = Factory::create()->image();
        $image = new UploadedFile($imagePath, 'image.jpg', 'image/jpeg', null, true);

        $dto = new GoodForCreate();
        $dto->name = "name";
        $dto->price = 2.25;
        $dto->description = "description";
        $dto->photo = $image;

        return $dto;
    }

    /**
     * @throws NonUniqueResultException
     */
    private function assertGoodCreated(int $id, GoodRepository $repository): void {
        $good = $repository->one($id);

        $this->assertNotNull($good);
        $this->assertEquals($id, $good->getId());
    }
}