<?php

namespace App\Http\Request\v1\Authorization;

use App\Http\Request\AbstractRequest;
use DigitalRevolution\SymfonyRequestValidation\ValidationRules;

class CheckResetTokenRequest extends AbstractRequest
{
    protected function getValidationRules(): ?ValidationRules
    {
        return new ValidationRules([
            'request' => [
                'reset_token' => 'required|string',
            ],
        ]);
    }

    public function getResetToken(): string
    {
        return $this->getRequest()->request->get('reset_token');
    }
}
