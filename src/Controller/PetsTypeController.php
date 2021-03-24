<?php
namespace App\Controller;

use App\Repository\PetsTypeRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class PetsTypeController
{

    private $petsTypeRepository;

    /**
     * PetsTypeController constructor.
     * @param PetsTypeRepository $petsTypeRepository
     */
    public function __construct(PetsTypeRepository $petsTypeRepository)
    {
        $this->petsTypeRepository = $petsTypeRepository;
    }

    /**
     * @Route("/pets-type", name="add_pet_type", methods={"POST"})
     */
    public function add(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $name = $data['name'];

        if (empty($name)) {
            throw new \Exception('Preencha todos os campos requeridos!');
        }

        $this->petsTypeRepository->createPetType($name);

        return new JsonResponse(['status' => 'Tipo de Pet salvo com sucesso!'], Response::HTTP_CREATED);
    }

    /**
     * @Route("/pets-type/{id}", name="get_one_pet_type", methods={"GET"})
     */
    public function get($id): JsonResponse
    {
        $petType = $this->petsTypeRepository->findOneBy(['id' => $id]);

        $data = [
            'id' => $petType->getId(),
            'name' => $petType->getName()
        ];

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/pets-type", name="get_all_pets_types", methods={"GET"})
     */
    public function getAll(): JsonResponse
    {
        $petsTypes = $this->petsTypeRepository->findAll();
        $data = [];

        foreach ($petsTypes as $petType) {
            $data[] = [
                'id' => $petType->getId(),
                'name' => $petType->getName()
            ];
        }

        return new JsonResponse($data, Response::HTTP_OK);
    }

    /**
     * @Route("/pets-type/{id}", name="update_pet_type", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {
        $pet = $this->petsTypeRepository->findOneBy(['id' => $id]);
        $data = json_decode($request->getContent(), true);

        empty($data['name']) ? true : $pet->setName($data['name']);

        $updatedPetType = $this->petsTypeRepository->updatePetType($pet);

        return new JsonResponse($updatedPetType->toArray(), Response::HTTP_OK);
    }

    /**
     * @Route("/pets-type/{id}", name="delete_pet_type", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $petType = $this->petsTypeRepository->findOneBy(['id' => $id]);

        $this->petsTypeRepository->removePetType($petType);

        return new JsonResponse(['status' => 'Pet excluído'], Response::HTTP_NO_CONTENT);
    }

}