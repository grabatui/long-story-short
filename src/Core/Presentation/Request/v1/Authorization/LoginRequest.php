<?php

namespace App\Core\Presentation\Request\v1\Authorization;

use App\Core\Presentation\Request\AbstractRequest;
use DigitalRevolution\SymfonyRequestValidation\ValidationRules;

class LoginRequest extends AbstractRequest
{
    protected function getValidationRules(): ?ValidationRules
    {
        return new ValidationRules([
            'request' => [
                'email' => 'required|email',
                'password' => 'required|string|between:7,40',
            ],
        ]);
    }
}
