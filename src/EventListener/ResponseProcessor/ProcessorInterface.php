<?php

namespace App\EventListener\ResponseProcessor;

use App\Core\Presentation\Entity\Enum\ResponseTypeEnum;
use Symfony\Component\HttpFoundation\Response;

interface ProcessorInterface
{
    public static function getRouteName(): string;

    public function processResponse(Response $response): void;

    public function getErrorType(): ResponseTypeEnum;
}
