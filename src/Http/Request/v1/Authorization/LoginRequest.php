<?php

namespace App\Http\Request\v1\Authorization;

use App\Http\Request\AbstractRequest;
use DigitalRevolution\SymfonyRequestValidation\ValidationRules;

class LoginRequest extends AbstractRequest
{
    protected function getValidationRules(): ?ValidationRules
    {
        return new ValidationRules([
            'request' => [
                ...$this->getCsrfTokenValidationRules(),

                'email' => 'required|email',
                'password' => 'required|string|between:7,40',
            ],
        ]);
    }
}
