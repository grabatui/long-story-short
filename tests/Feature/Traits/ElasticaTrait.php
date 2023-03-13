<?php

namespace App\Tests\Feature\Traits;

use App\Tests\Feature\v1\Entity\SearchTest\TestClient;
use RuntimeException;

trait ElasticaTrait
{
    /**
     * @When в elastic при :requestMethod запросе в :requestQuery с данными :requestPath отдаются данные из :responsePath
     */
    public function thereAreElementsInElastic(
        string $requestMethod,
        string $requestQuery,
        string $requestPath,
        string $responsePath
    ): void {
        if (!in_array($requestMethod, ['GET', 'POST'])) {
            throw new RuntimeException('Unknown method ' . $requestMethod);
        }

        TestClient::setResponseByRequest(
            $requestQuery,
            $requestMethod,
            json_decode($this->getAndCheckDataFilePath($requestPath), true),
            $this->getAndCheckDataFilePath($responsePath)
        );
    }
}
