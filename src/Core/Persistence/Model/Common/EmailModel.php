<?php

namespace App\Core\Persistence\Model\Common;

use App\Core\Domain\Common\Email\Entity\EmailInterface;
use App\Core\Domain\Common\Email\Entity\TemplateEmail;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class EmailModel
{
    public function fromDomain(EmailInterface $email): Email
    {
        $resultEmail = match (get_class($email)) {
            TemplateEmail::class => $this->makeTemplatedEmail($email)
        };

        return $resultEmail
            ->from(
                new Address($email->getFrom())
            )
            ->to(
                new Address($email->getTo())
            )
            ->subject($email->getSubject())
            ->context(
                $email->getContext()
            );
    }

    private function makeTemplatedEmail(TemplateEmail $email): TemplatedEmail
    {
        return (new TemplatedEmail())
            ->htmlTemplate(
                $email->getTemplateName()
            );
    }
}
