<?php

namespace App\Controller;

use App\Entity\PersonalizedPageContent;
use App\Services\CustomResponse;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class PersonalizedPageContentController extends AbstractController
{
    private $customResponse;

    public function __construct(SerializerInterface $serializer)
    {
        $this->customResponse = new CustomResponse($serializer);
    }

     /**
     * @Route("/api/personalizedPageContent", methods={"GET"})

     * @OA\Response(
     *     response=200,
     *     description="Returns a array of discipline",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=PersonnalizedPageContent::class))
     *     )
     * )
     * @OA\Tag(name="Discipline")
     */
    public function index(EntityManagerInterface $entityManager): Response
    {
        $personalizedPageContent = $entityManager->getRepository(PersonalizedPageContent::class)->findAll();

        return $this->customResponse->createResponse($personalizedPageContent, Response::HTTP_OK);
    }

    /**
     * @Route("/api/personalizedPageContent/{page}", methods={"GET"})
     */
    public function getByPage(string $page, EntityManagerInterface $entityManager): Response
    {
        $checkPresenceInTheList = PersonalizedPageContent::checkThePresenceOfTheRequestedPageInTheList($page);
        
        if($checkPresenceInTheList) {
           $personalizedPageContent = $entityManager->getRepository(PersonalizedPageContent::class)->findBy(['page' => $page]);
        }

        return $this->customResponse->createResponse($personalizedPageContent, Response::HTTP_OK);
    }
}