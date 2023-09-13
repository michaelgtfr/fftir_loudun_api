<?php

namespace App\Controller;

use App\Entity\Schredule;
use App\Services\CustomResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SchreduleController extends AbstractController
{
    private $customResponse;

    public function __construct(SerializerInterface $serializer)
    {
        $this->customResponse = new CustomResponse($serializer);
    }

    /**
     * @Route("/api/showsSchredules", methods={"GET"})
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $sportsShootingDisciplines = $entityManager->getRepository(Schredule::class)->findAll();

        return $this->customResponse->createResponse($sportsShootingDisciplines, Response::HTTP_OK);
    }
}