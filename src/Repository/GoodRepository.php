<?php

namespace App\Repository;

use App\Entity\Good;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Exception;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Good>
 *
 * @method Good|null find($id, $lockMode = null, $lockVersion = null)
 * @method Good|null findOneBy(array $criteria, array $orderBy = null)
 * @method Good[]    findAll()
 * @method Good[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GoodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Good::class);
    }

    public function save(Good $good): void
    {
        $this->_em->persist($good);
        $this->_em->flush();
    }

    public function delete(int $id): void {
        $connection = $this->_em->getConnection();
        $connection->delete('goods', ['id' => $id]);
    }
}
