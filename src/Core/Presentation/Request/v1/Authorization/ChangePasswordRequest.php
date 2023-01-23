<?php

namespace App\Core\Presentation\Request\v1\Authorization;

use App\Core\Presentation\Request\AbstractRequest;
use DigitalRevolution\SymfonyRequestValidation\ValidationRules;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ChangePasswordRequest extends AbstractRequest
{
    protected function getValidationRules(): ?ValidationRules
    {
        return new ValidationRules([
            'request' => [
                'reset_token' => 'required|string',
                'password' => 'required|string|between:7,40',
                'password_repeat' => [
                    'required|string|between:7,40',
                    new Callback(
                        $this->checkSamePassword(...)
                    ),
                ],
            ],
        ]);
    }

    public function checkSamePassword(mixed $passwordRepeat, ExecutionContextInterface $context, $payload): void
    {
        if ($this->getPassword() !== $passwordRepeat) {
            $context
                ->buildViolation('Пароли должны совпадать')
                ->setCode('passwords_not_same')
                ->addViolation();
        }
    }

    public function getResetToken(): string
    {
        return $this->getRequest()->request->get('reset_token');
    }

    public function getPassword(): string
    {
        return $this->getRequest()->request->get('password') ?: '';
    }
}
