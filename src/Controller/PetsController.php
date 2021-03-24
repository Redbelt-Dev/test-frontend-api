<?php
namespace App\Controller;

use App\Repository\PetsRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PetsController
{

    private $petsRepository;

    /**
     * PetsController constructor.
     * @param $petsRepository
     */
    public function __construct(PetsRepository $petsRepository)
    {
        $this->petsRepository = $petsRepository;
    }

    /**
     * @Route("/pets", name="add_pet", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $type = $data['type'];
        $name = $data['name'];
        $owner = $data['owner'];
        $race = empty($data['race'])?null:$data['race'];

        if (empty($type) || empty($name) || empty($owner)) {
            throw new \Exception('Preencha todos os campos requeridos!');
        }

        $this->petsRepository->createPet($type, $name, $owner, $race);

        return new JsonResponse(['status' => 'Pet salvo com sucesso!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/pets/{id}", name="get_one_pet", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $pet = $this->petsRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $pet->getId(),
            'type' => $pet->getType(),
            'name' => $pet->getName(),
            'owner' => $pet->getOwner(),
            'race' => $pet->getRace(),
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/pets", name="get_all_pets", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $pets = $this->petsRepository->findAll();
        $data = [];

        foreach ($pets as $pet) {
            $data[] = [
                'id' => $pet->getId(),
                'type' => $pet->getType(),
                'name' => $pet->getName(),
                'owner' => $pet->getOwner(),
                'race' => $pet->getRace(),
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/pets/{id}", name="update_pet", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $pet = $this->petsRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['type']) ? true : $pet->setType($data['type']);
        empty($data['name']) ? true : $pet->setName($data['name']);
        empty($data['owner']) ? true : $pet->setOwner($data['owner']);
        empty($data['race']) ? true : $pet->setRace($data['race']);

        $updatedPet = $this->petsRepository->updatePet($pet);

        return new JsonResponse($updatedPet->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/pets/{id}", name="delete_pet", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $pet = $this->petsRepository->findOneBy(['id' => $id]);

        $this->petsRepository->removePet($pet);

        return new JsonResponse(['status' => 'Pet excluído'], Response::HTTP_NO_CONTENT);
    }

}