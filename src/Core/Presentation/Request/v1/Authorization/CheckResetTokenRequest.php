<?php

namespace App\Core\Presentation\Request\v1\Authorization;

use App\Core\Presentation\Request\AbstractRequest;
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
