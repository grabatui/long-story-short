<?php

namespace App\Core\Symfony\Security;

use App\Http\Entity\Enum\ResponseTypeEnum;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\JsonLoginAuthenticator;
use Symfony\Contracts\Translation\TranslatorInterface;

class CustomJsonLoginAuthenticator extends JsonLoginAuthenticator
{
    private ?TranslatorInterface $translator = null;

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        if (null !== $this->translator) {
            $errorMessage = $this->translator->trans($exception->getMessageKey(), $exception->getMessageData(), 'security');
        } else {
            $errorMessage = strtr($exception->getMessageKey(), $exception->getMessageData());
        }

        return new JsonResponse(
            [
                'message' => $errorMessage,
                'type' => ResponseTypeEnum::output_error->name,
                'errors' => [],
            ],
            JsonResponse::HTTP_UNAUTHORIZED
        );
    }

    public function setTranslator(TranslatorInterface $translator): void
    {
        $this->translator = $translator;

        parent::setTranslator($translator);
    }
}
