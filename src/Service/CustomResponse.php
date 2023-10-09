<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\ConstraintViolationList;

class CustomResponse extends Response
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function createResponse($data, int $status = Response::HTTP_OK, ?array $metadata = []): Response
    {
        try {
            $responseData = [
                'data' => $data,
                'metadata' => $metadata,
            ];

            $content = $this->serializer->serialize($responseData, 'json');

            return new Response($content, $status, ['Content-Type' => 'application/json', 'Access-Control-Allow-Origin' => '*']);
        } catch (\Exception $e) {
            return new Response('Internal Server Error', Response::HTTP_INTERNAL_SERVER_ERROR, ['Content-Type' => 'application/json', 'Access-Control-Allow-Origin' => '*']);
        }
    }

    public function erreurValidatorResponse(ConstraintViolationList $errors): Response
    {
        $arrayOfErrors = [];

        foreach($errors as $error) {
            $constraint = $error->getConstraint();
            $arrayOfErrors[] = ['message' => $constraint->message, 'field' => $constraint->fields];
        }

        try {
            $responseData = [
                'message' => 'Désolé mais un problème est survenu lors de l\'éxécution de la demande',
                'error' => $arrayOfErrors,
            ];

            $content = $this->serializer->serialize($responseData, 'json');

            return new Response($content, Response::HTTP_BAD_REQUEST, ['Content-Type' => 'application/json', 'Access-Control-Allow-Origin' => '*']);
        } catch (\Exception $e) {
            return new Response('Internal Server Error', Response::HTTP_INTERNAL_SERVER_ERROR, ['Content-Type' => 'application/json', 'Access-Control-Allow-Origin' => '*']);
        }
    }
}