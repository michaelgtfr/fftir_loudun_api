<?php

namespace App\Controller;

use App\Services\CustomResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class BlogPostController extends AbstractController
{
    private $customResponse;

    public function __construct(private SerializerInterface $serializer)
    {
        $this->customResponse = new CustomResponse($this->serializer);
    }

     /**
     * @Route("/api/blogPost", methods={"POST"})
     * @OA\Tag(name="blogPost")
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
}