<?php

namespace App\Request;

use App\Exception\Request\ConstraintViolationsException;
use DigitalRevolution\SymfonyRequestValidation\AbstractValidatedRequest;
use DigitalRevolution\SymfonyRequestValidation\Constraint\RequestConstraintFactory;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class AbstractRequest extends AbstractValidatedRequest
{
    private const CSRF_TOKEN = 'unique_string';

    public function __construct(
        RequestStack $requestStack,
        ValidatorInterface $validator,
        RequestConstraintFactory $constraintFactory,
        private readonly CsrfTokenManagerInterface $csrfTokenManager
    ) {
        parent::__construct($requestStack, $validator, $constraintFactory);
    }

    protected function handleViolations(ConstraintViolationListInterface $violationList): ?Response
    {
        throw new ConstraintViolationsException($violationList);
    }

    public function checkCsrfToken(mixed $token, ExecutionContextInterface $context, $payload): void
    {
        if (!$token) {
            return;
        }

        $token = new CsrfToken(self::CSRF_TOKEN, $token);

        if (!$this->csrfTokenManager->isTokenValid($token)) {
            $context
                ->buildViolation('Токен не валидный')
                ->setCode('csrf_is_invalid')
                ->addViolation();
        }
    }
}
