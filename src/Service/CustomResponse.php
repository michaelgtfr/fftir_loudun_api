<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

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
            return new Response('Internal Server Error', 500);
        }
    }
}