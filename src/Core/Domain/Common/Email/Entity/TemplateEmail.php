<?php

namespace App\Core\Domain\Common\Email\Entity;

readonly class TemplateEmail implements EmailInterface
{
    public function __construct(
        private string $from,
        private string $to,
        private string $subject,
        private string $templateName,
        private array $context
    ) {
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function getTemplateName(): string
    {
        return $this->templateName;
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
