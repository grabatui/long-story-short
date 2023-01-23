<?php

namespace App\EventListener;

use App\Core\Presentation\Entity\Enum\ResponseTypeEnum;
use App\EventListener\ResponseProcessor\AuthorizationLoginProcessor;
use App\EventListener\ResponseProcessor\ProcessorInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

readonly class ResponseListener implements EventSubscriberInterface
{
    private const CONTENT_TYPE_HEADER_KEY = 'Content-Type';
    private const APPLICATION_JSON_HEADER_VALUE = 'application/json';

    /**
     * @var ProcessorInterface[]
     */
    private array $processors;

    public function __construct(
        AuthorizationLoginProcessor $authorizationLoginProcessor
    ) {
        $this->processors = [
            $authorizationLoginProcessor,
        ];
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::RESPONSE => 'onKernelResponse'];
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        if (!$this->isJson($event)) {
            return;
        }

        $responseProcessor = $this->tryToResolveProcessor(
            $event->getRequest()->attributes->get('_route')
        );

        $responseProcessor?->processResponse($response);

        $data = json_decode($response->getContent(), true);

        $isSuccess = in_array($response->getStatusCode(), [200, 201]);

        if ($data && $this->isResponseAlreadyFormatted($isSuccess, $data)) {
            return;
        }

        $response->setContent(
            json_encode([
                'message' => $isSuccess ? null : ($data['message'] ?? null),
                'data' => $isSuccess ? $data : [],
                'type' => ResponseTypeEnum::error->value,
                'errors' => [],
            ])
        );
    }

    private function tryToResolveProcessor(?string $route): ?ProcessorInterface
    {
        if (!$route) {
            return null;
        }

        foreach ($this->processors as $processor) {
            if ($processor::getRouteName() === $route) {
                return $processor;
            }
        }

        return null;
    }

    private function isResponseAlreadyFormatted(bool $isSuccess, array $data): bool
    {
        if ($isSuccess) {
            return (
                array_key_exists('data', $data)
                && array_key_exists('type', $data)
                && ResponseTypeEnum::tryFrom($data['type'])
            );
        }

        return (
            array_key_exists('message', $data)
            && array_key_exists('type', $data)
            && ResponseTypeEnum::tryFrom($data['type'])
            && array_key_exists('errors', $data)
        );
    }

    private function isJson(ResponseEvent $event): bool
    {
        return self::APPLICATION_JSON_HEADER_VALUE === $event->getRequest()->headers->get(self::CONTENT_TYPE_HEADER_KEY);
    }
}
