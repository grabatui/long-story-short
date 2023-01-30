<?php

namespace App\Tests\Feature\Traits;

use RuntimeException;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Event\MessageEvents;

trait EmailTrait
{
    /**
     * @Then есть отправленных писем: :count
     */
    public function thereIsCountOfSentEmails(int $count): void
    {
        $actualCount = count($this->getEmailEvents()->getEvents());

        if ($actualCount !== $count) {
            throw new RuntimeException(
                sprintf('Количество отправленных писем ожидалось: %d, отправилось: %d', $count, $actualCount)
            );
        }
    }

    /**
     * @Then в последнем отправленном письме есть фраза :message
     */
    public function thereIsMessageInTheLastEmail(string $message): void
    {
        $emailMessages = $this->getEmailEvents()->getMessages();

        if (empty($emailMessages)) {
            throw new RuntimeException('Нет ни одного отправленного сообщения');
        }

        $emailMessage = reset($emailMessages);

        $emailMessage = $emailMessage instanceof TemplatedEmail
            ? $emailMessage->getHtmlBody()
            : $emailMessage->toString();

        if (mb_strpos($emailMessage, $message) === false) {
            throw new RuntimeException('Сообщение не найдено');
        }
    }

    private function getEmailEvents(): MessageEvents
    {
        return $this->getContainer()->get('mailer.message_logger_listener')->getEvents();
    }
}
