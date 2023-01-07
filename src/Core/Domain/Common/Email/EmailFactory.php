<?php

namespace App\Core\Domain\Common\Email;

use App\Core\Domain\Common\Email\Entity\TemplateEmail;
use App\Core\Domain\Common\Email\Entity\Enum\EmailTypeEnum;

readonly class EmailFactory
{
    private const TEMPLATES_DIRECTORY = 'email/';

    public function __construct(
        private GetDefaultEmailFromInterface $getDefaultEmailFrom
    ) {
    }

    public function makeByTemplate(
        string $to,
        string $subject,
        EmailTypeEnum $type,
        array $context = []
    ): TemplateEmail {
        return new TemplateEmail(
            $this->getDefaultEmailFrom->get(),
            $to,
            $subject,
            self::TEMPLATES_DIRECTORY . $this->makeTemplateName($type),
            $context
        );
    }

    private function makeTemplateName(EmailTypeEnum $type): string
    {
        return match ($type) {
            EmailTypeEnum::resetToken => 'reset_token.twig',
        };
    }
}
