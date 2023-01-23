<?php

namespace App\Core\UseCase\Authorization;

use App\Core\Domain\Authorization\ResetToken\MakeResetTokenByUserIdInterface;
use App\Core\Domain\Common\Email\EmailFactory;
use App\Core\Domain\Common\Email\Entity\Enum\EmailTypeEnum;
use App\Core\Domain\Common\Email\GetHelpEmailInterface;
use App\Core\Domain\Common\Email\SendEmailInterface;
use App\Core\Domain\Common\User\GetUserIdByEmailInterface;

readonly class SendResetPasswordEmailUseCase
{
    public function __construct(
        private GetUserIdByEmailInterface $getUserIdByEmail,
        private MakeResetTokenByUserIdInterface $makeResetTokenByUserId,
        private EmailFactory $emailFactory,
        private SendEmailInterface $sendEmail,
        private GetHelpEmailInterface $getHelpEmail
    ) {
    }

    public function run(string $email): void
    {
        $userId = $this->getUserIdByEmail->get($email);

        $resetToken = $this->makeResetTokenByUserId->run($userId);
        $helpEmail = $this->getHelpEmail->get();

        $this->sendEmail->run(
            $this->emailFactory->makeByTemplate(
                to: $email,
                subject: '',
                type: EmailTypeEnum::resetToken,
                context: compact('resetToken', 'helpEmail')
            )
        );
    }
}
