<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Services\CustomResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TagController  extends AbstractController
{
    private $customResponse;

    public function __construct(private SerializerInterface $serializer)
    {
        $this->customResponse = new CustomResponse($this->serializer);
    }

     /**
     * @Route("/api/tag", methods={"GET"})

     * @OA\Response(
     *     response=200,
     *     description="Returns a array of tags",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Tag::class))
     *     )
     * )
     * @OA\Tag(name="Tag")
     */
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $page = $request->get('page') ? $request->get('page') : 1;
        $numberItemReturned = $request->get('numberItem') ? $request->get('numberItem') : null;

        $offset = ($page - 1) * $numberItemReturned;

        $tagRepository  = $entityManager->getRepository(Tag::class);
        $personalizedPageContent = $tagRepository ->findBy([], ['name' => 'ASC'], $numberItemReturned, $offset);
        $totalItem = $tagRepository ->count([]);

        $metadata = [
            'page' => $request->get('page'), 
            'numberItemReturned' => $numberItemReturned,
            'totalItem' => $totalItem
            ];

        return $this->customResponse->createResponse($personalizedPageContent, Response::HTTP_OK, $metadata);
    }


     /**
     * @Route("/api/tag/{id}", methods={"GET"})
     * @OA\Response(
     *     response=200,
     *     description="Returns the tag ask",
     *     @OA\JsonContent(
     *        type="array",
     *        @OA\Items(ref=@Model(type=Tag::class))
     *     )
     * )
     * @OA\Tag(name="Tag")
     */
    public function show(Tag $tag): Response
    {
        return $this->customResponse->createResponse($tag, Response::HTTP_OK);
    }

     /**
     * @Route("/api/tag", methods={"POST"})
     * @OA\Tag(name="Tag")
     */
    public function store(Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager): Response
    {
        $tag = $this->serializer->deserialize($request->getContent(), Tag::class, 'json');

        $errors = $validator->validate($tag);

        if (count($errors) > 0) {
            return $this->customResponse->erreurValidatorResponse($errors);
        }

        $entityManager->persist($tag);
        $entityManager->flush();
        
        return $this->customResponse->createResponse($tag, Response::HTTP_CREATED);
    }

    /**
     * @Route("/api/tag/{id}", methods={"PUT"})
     * @OA\Tag(name="Tag")
     */
    public function update(Tag $tag, Request $request, ValidatorInterface $validator, EntityManagerInterface $entityManager)
    {
        $dataTagUpdated = json_decode($request->getContent(), true);

        $tag->hydrateDTO($dataTagUpdated);

        $entityManager->flush();
        
        return $this->customResponse->createResponse($tag, Response::HTTP_ACCEPTED);
    }

    /**
     * @Route("/api/tag/{id}", methods={"DELETE"})
     * @OA\Tag(name="Tag")
     */
    public function delete(Tag $tag, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($tag);
        $entityManager->flush();

        return $this->customResponse->createResponse($tag, Response::HTTP_ACCEPTED);
    }
}