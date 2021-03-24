<?php
namespace App\Repository;

use App\Entity\Pets;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

class PetsRepository extends ServiceEntityRepository
{
    private $manager;

    /**
     * PetsRepository constructor.
     * @param ManagerRegistry $registry
     * @param EntityManagerInterface $manager
     */
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Pets::class);
        $this->manager = $manager;
    }

    /**
     * @param $type
     * @param $name
     * @param $owner
     * @param null $race
     */
    public function createPet($type, $name, $owner, $race = null)
    {
        $newPet = new Pets();

        $newPet
            ->setType($type)
            ->setName($name)
            ->setOwner($owner)
            ->setRace($race);

        $this->manager->persist($newPet);
        $this->manager->flush();
    }

    /**
     * @param Pets $pets
     * @return Pets
     */
    public function updatePet(Pets $pets): Pets
    {
        $this->manager->persist($pets);
        $this->manager->flush();

        return $pets;
    }

    /**
     * @param Pets $pet
     */
    public function removePet(Pets $pet)
    {
        $this->manager->remove($pet);
        $this->manager->flush();
    }

}