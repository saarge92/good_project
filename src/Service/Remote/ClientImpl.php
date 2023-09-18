<?php

declare(strict_types=1);

namespace App\Service\Remote;

use Exception;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ClientImpl implements Client
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
        private readonly SerializerInterface $serializer)
    {
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     * @throws Exception
     */
    public function get(string $url): Good
    {
        $response = $this->httpClient->request('GET', $url);
        $json = $response->getContent();
        $statusCode = $response->getStatusCode();

        if ($statusCode != Response::HTTP_OK) {
            throw new Exception("remote request finished with code $statusCode");
        }

        return $this->serializer->deserialize($json, Good::class, 'json');
    }
}