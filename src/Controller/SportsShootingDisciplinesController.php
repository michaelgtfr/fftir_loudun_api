<?php

namespace App\Controller;

use App\Entity\SportsShootingDisciplines;
use App\Services\CustomResponse;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SportsShootingDisciplinesController extends AbstractController
{
    private $customResponse;

    public function __construct(SerializerInterface $serializer)
    {
        $this->customResponse = new CustomResponse($serializer);
    }

    /**
     * @Route("/api/showsShootingsDisciplines", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns a array of discipline",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=SportShootingDiscipline::class))
     *     )
     * )
     * @OA\Tag(name="Discipline")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $sportsShootingDisciplines = $entityManager->getRepository(SportsShootingDisciplines::class)->findAll();

        return $this->customResponse->createResponse($sportsShootingDisciplines, Response::HTTP_OK);
    }
}