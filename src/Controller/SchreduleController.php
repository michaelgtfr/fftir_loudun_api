<?php

namespace App\Controller;

use App\Entity\Schredule;
use App\Services\CustomResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SchreduleController extends AbstractController
{
    private $customResponse;

    public function __construct(private SerializerInterface $serializer)
    {
        $this->customResponse = new CustomResponse($this->serializer);
    }

    /**
     * @Route("/api/schredules", methods={"GET"})
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $page = $request->get('page') ? $request->get('page') : 1;

        $numberItemReturned = 20;
        $offset = ($page - 1) * $numberItemReturned;

        $schreduleRepository  = $entityManager->getRepository(Schredule::class);
        $personalizedPageContent = $schreduleRepository ->findBy([], [], $numberItemReturned, $offset);
        $totalItem = $schreduleRepository ->count([]);

        $metadata = [
            'page' => $request->get('page'), 
            'numberItemReturned' => $numberItemReturned,
            'totalItem' => $totalItem
            ];

        return $this->customResponse->createResponse($personalizedPageContent, Response::HTTP_OK, $metadata);
    }

    /**
     * @Route("/api/schredule", methods={"POST"})
     * @OA\Tag(name="Schredule")
     */
    public function store(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $schredule = $this->serializer->deserialize($request->getContent(), Schredule::class, 'json');

        $errors = $validator->validate($schredule);

        if (count($errors) > 0) {
            return $this->customResponse->erreurValidatorResponse($errors);
        }

        $entityManager->persist($schredule);
        $entityManager->flush();
        
        return $this->customResponse->createResponse($schredule, Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/schredule/{id}", methods={"PUT"})
     * @OA\Tag(name="Schredule")
     */
    public function update(Schredule $schredule, Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $dataSchreduleUpdated = json_decode($request->getContent(), true);

        $schredule->hydrateDTO($dataSchreduleUpdated);

        $entityManager->flush();
        
        return $this->customResponse->createResponse($schredule, Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/api/schredule/{id}", methods={"DELETE"})
     * @OA\Tag(name="Schredule")
     */
    public function delete(Schredule $schredule, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($schredule);
        $entityManager->flush();

        return $this->customResponse->createResponse($schredule, Response::HTTP_ACCEPTED);
    }
}