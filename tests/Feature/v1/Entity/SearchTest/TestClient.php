<?php

namespace App\Tests\Feature\v1\Entity\SearchTest;

use Elastica\Request;
use Elastica\Response;
use FOS\ElasticaBundle\Elastica\Client;
use RuntimeException;
use Symfony\Component\DependencyInjection\Attribute\AsDecorator;

#[AsDecorator(decorates: 'fos_elastica.client')]
class TestClient extends Client
{
    private const DEFAULT_RESPONSES = [
        '_bulk' => '{"took":128,"errors":false,"items":[{"update":{"_index":"movies","_id":"21","_version":1,"result":"created","_shards":{"total":2,"successful":1,"failed":0},"_seq_no":0,"_primary_term":1,"status":201}}]}',
    ];

    private static array $requestsAndResponses = [];

    public static function setResponseByRequest(string $path, string $method, array $dataOrQuery, string $response): void
    {
        self::$requestsAndResponses[] = [
            $path,
            $method,
            $dataOrQuery,
            $response
        ];
    }

    public function request(
        string $path,
        string $method = Request::GET,
        $data = [],
        array $query = [],
        string $contentType = Request::DEFAULT_CONTENT_TYPE
    ): Response {
        if (array_key_exists($path, self::DEFAULT_RESPONSES)) {
            return new Response(self::DEFAULT_RESPONSES[$path], 200);
        }

        foreach (self::$requestsAndResponses as $requestAndResponse) {
            if (
                $requestAndResponse[0] === $path
                && $requestAndResponse[1] === $method
                && (
                    json_encode($requestAndResponse[2]) === json_encode($data)
                    || json_encode($requestAndResponse[2]) === json_encode($query)
                )
            ) {
                return new Response($requestAndResponse[3], 200);
            }
        }

        throw new RuntimeException(
            sprintf('Для [%s] %s не найдено ни одного подходящего ответа', $method, $path)
        );
    }
}
