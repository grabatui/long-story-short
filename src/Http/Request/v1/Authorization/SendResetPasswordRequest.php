<?php

namespace App\Http\Request\v1\Authorization;

use App\Core\Domain\Common\User\IsEmailAlreadyExistsInterface;
use App\Http\Request\AbstractRequest;
use DigitalRevolution\SymfonyRequestValidation\Constraint\RequestConstraintFactory;
use DigitalRevolution\SymfonyRequestValidation\ValidationRules;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class SendResetPasswordRequest extends AbstractRequest
{
    public function __construct(
        RequestStack $requestStack,
        ValidatorInterface $validator,
        RequestConstraintFactory $constraintFactory,
        private readonly IsEmailAlreadyExistsInterface $isEmailAlreadyExists
    ) {
        parent::__construct($requestStack, $validator, $constraintFactory);
    }

    protected function getValidationRules(): ?ValidationRules
    {
        return new ValidationRules([
            'request' => [
                'email' => [
                    'required|email',
                    new Callback(
                        $this->checkUserExists(...)
                    ),
                ],
            ],
        ]);
    }

    public function checkUserExists(mixed $email, ExecutionContextInterface $context, $payload): void
    {
        if (!$this->isEmailAlreadyExists->is($email)) {
            $context
                ->buildViolation('Пользователь с таким email\'ом не найден')
                ->setCode('email_exists')
                ->addViolation();
        }
    }

    public function getEmail(): string
    {
        return $this->getRequest()->request->get('email');
    }
}
