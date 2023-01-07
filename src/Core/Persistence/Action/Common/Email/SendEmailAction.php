<?php

namespace App\Core\Persistence\Action\Common\Email;

use App\Core\Domain\Common\Email\Entity\EmailInterface;
use App\Core\Domain\Common\Email\SendEmailInterface;
use App\Core\Persistence\Model\Common\EmailModel;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

readonly class SendEmailAction implements SendEmailInterface
{
    public function __construct(
        private EmailModel $emailModel,
        private MailerInterface $mailer
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function run(EmailInterface $email): void
    {
        $email = $this->emailModel->fromDomain($email);

        $this->mailer->send($email);
    }
}
