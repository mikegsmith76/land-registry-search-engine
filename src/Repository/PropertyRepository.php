<?php

namespace App\Repository;

use App\Entity\Property;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    public function findOneByPostCode(string $postCode, string $houseNumber = "", string $unitName = ""): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.postcode = :postcode')
            ->andWhere('p.house_number_or_name = :house_number_or_name')
            ->andWhere('p.unit_name = :unit_name')
            ->setParameter('postcode', $postCode)
            ->setParameter('house_number_or_name', $houseNumber)
            ->setParameter('unit_name', $unitName)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function search(string $postCode, string $houseNumber = "", string $unitName = ""): array
    {
        $postCode = str_replace(" ", "", $postCode);

        $queryBuilder = $this->createQueryBuilder('p')
            ->andWhere('p.postcode_search LIKE :postcode')
            ->setParameter('postcode', $postCode . "%");

        if (!empty($houseNumber)) {
            $queryBuilder
                ->andWhere('p.house_number_or_name LIKE :house_number_or_name')
                ->setParameter('house_number_or_name', $houseNumber . "%");
        }

        if (!empty($unitName)) {
            $queryBuilder
                ->andWhere('p.unit_name LIKE :unit_name')
                ->setParameter('unit_name', $unitName . "%");
        }

        $query = $queryBuilder
            ->orderBy("p.postcode", "asc")
            ->orderBy("p.house_number_or_name", "asc")
            ->getQuery();

        return $query->getResult();
    }
}
