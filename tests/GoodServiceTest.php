<?php

declare(strict_types=1);

namespace App\Tests;

use App\DTO\GoodForCreate;
use App\DTO\GoodForUpdate;
use App\Repository\GoodRepository;
use App\Service\GoodService;
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
        /** @var GoodService $service */
        $service = $container->get(GoodService::class);

        $dto = $this->initGoodForCreateDTO();
        $id = $service->create($dto);

        $this->assertGoodCreated($id, $container->get(GoodRepository::class));
    }

    /**
     * @throws \Exception
     */
    public function testUpdate(): void
    {
        $container = self::getContainer();
        /** @var GoodService $service */
        $service = $container->get(GoodService::class);

        $createDto = $this->initGoodForCreateDTO();
        $id = $service->create($createDto);

        $updateDto = $this->initGoodForUpdateDTO($id);
        $service->update($updateDto);

        $this->assertGoodUpdated($updateDto, $container->get(GoodRepository::class));
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

    private function initGoodForUpdateDTO($id): GoodForUpdate
    {
        $imagePath = Factory::create()->image();
        $image = new UploadedFile($imagePath, 'image.jpg', 'image/jpeg', null, true);

        return new GoodForUpdate(
            $id,
            "new_name",
            1.25,
            $image,
            "new_description",
        );
    }

    /**
     * @throws NonUniqueResultException
     */
    private function assertGoodCreated(int $id, GoodRepository $repository): void
    {
        $good = $repository->one($id);

        $this->assertNotNull($good);
        $this->assertEquals($id, $good->getId());
    }

    /**
     * @throws NonUniqueResultException
     */
    private function assertGoodUpdated(GoodForUpdate $dto, GoodRepository $repository) : void
    {
        $good = $repository->one($dto->id);

        $this->assertNotNull($good);
        $this->assertEquals($dto->name, $good->getName());
        $this->assertEquals($dto->price, $good->getPrice());
        $this->assertEquals($dto->description, $good->getDescription());
    }
}