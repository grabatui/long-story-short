<?php

namespace App\EventListener\ResponseProcessor;

use Symfony\Component\HttpFoundation\Response;

interface ProcessorInterface
{
    public static function getRouteName(): string;

    public function processResponse(Response $response): void;
}
