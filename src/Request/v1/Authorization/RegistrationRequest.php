<?php

namespace App\Request\v1\Authorization;

use App\Core\Domain\Common\User\IsEmailAlreadyExistsInterface;
use App\Request\AbstractRequest;
use DigitalRevolution\SymfonyRequestValidation\Constraint\RequestConstraintFactory;
use DigitalRevolution\SymfonyRequestValidation\ValidationRules;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class RegistrationRequest extends AbstractRequest
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
                        $this->checkUniqueEmail(...)
                    ),
                ],
                'name' => 'required|string',
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

    public function checkUniqueEmail(mixed $email, ExecutionContextInterface $context, $payload): void
    {
        if ($this->isEmailAlreadyExists->is($email)) {
            $context
                ->buildViolation('Такой Email уже существует')
                ->setCode('email_exists')
                ->addViolation();
        }
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

    public function getEmail(): string
    {
        return $this->getRequest()->request->get('email');
    }

    public function getName(): string
    {
        return $this->getRequest()->request->get('name');
    }

    public function getPassword(): string
    {
        return $this->getRequest()->request->get('password') ?: '';
    }
}
