<?php

namespace App\EventListener\ResponseProcessor;

use App\Core\Presentation\Entity\Enum\ResponseTypeEnum;

abstract class AbstractProcessor implements ProcessorInterface
{
    protected function wrapData(array $data): array
    {
        return [
            'data' => $data,
            'type' => ResponseTypeEnum::success->value,
        ];
    }

    public function getErrorType(): ResponseTypeEnum
    {
        return ResponseTypeEnum::error;
    }
}
