<?php

namespace App\EventListener\ResponseProcessor;

use App\Core\Presentation\Entity\Enum\ResponseTypeEnum;
use Symfony\Component\HttpFoundation\Response;

class AuthorizationLoginProcessor extends AbstractProcessor
{
    public static function getRouteName(): string
    {
        return 'v1_authorization_login';
    }

    public function processResponse(Response $response): void
    {
        $data = json_decode($response->getContent(), true);

        $response->setContent(
            json_encode($this->wrapData($data))
        );
    }

    public function getErrorType(): ResponseTypeEnum
    {
        return ResponseTypeEnum::output_error;
    }
}
