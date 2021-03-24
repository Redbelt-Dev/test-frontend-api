<?php
namespace App\Repository;

use App\Entity\PetsType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class PetsTypeRepository extends ServiceEntityRepository
{
    private $manager;

    /**
     * PetsTypeRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, PetsType::class);
        $this->manager = $manager;
    }

    /**
     * @param $name
     */
    public function createPetType($name)
    {
        $newPetType = new PetsType();

        $newPetType
            ->setName($name);

        $this->manager->persist($newPetType);
        $this->manager->flush();
    }

    /**
     * @param PetsType $petType
     * @return PetsType
     */
    public function updatePetType(PetsType $petType): PetsType
    {
        $this->manager->persist($petType);
        $this->manager->flush();

        return $petType;
    }

    /**
     * @param PetsType $petType
     */
    public function removePetType(PetsType $petType)
    {
        $this->manager->remove($petType);
        $this->manager->flush();
    }

}