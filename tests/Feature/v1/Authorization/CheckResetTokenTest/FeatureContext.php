<?php

namespace App\Tests\Feature\v1\Authorization\CheckResetTokenTest;

use App\Core\Persistence\Repository\ResetPasswordRequestRepository;
use App\Core\Persistence\Repository\UserRepository;
use App\Tests\Feature\AbstractFeatureContext;
use DateTimeImmutable;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use RuntimeException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\ResetPassword\ResetPasswordHelperInterface;

class FeatureContext extends AbstractFeatureContext
{
    private ?string $resetToken = null;

    public function __construct(
        JWTEncoderInterface $JWTEncoder,
        UserPasswordHasherInterface $hasher,
        UserRepository $userRepository,
        private readonly ResetPasswordHelperInterface $resetPasswordHelper,
        private readonly ResetPasswordRequestRepository $resetPasswordRequestRepository
    ) {
        parent::__construct($JWTEncoder, $hasher, $userRepository);
    }

    /**
     * @When в базе данных есть просроченный токен восстановления пароля
     */
    public function thereIsExpiredResetTokenInDatabase(): void
    {
        $this->saveResetTokenInDatabase(true);
    }

    /**
     * @When в базе данных есть токен восстановления пароля
     */
    public function thereIsResetTokenInDatabase(): void
    {
        $this->saveResetTokenInDatabase(false);
    }

    /**
     * @When мы делаем post-запрос в :path с запомненным токеном
     */
    public function weDoPostRequestToPathWithSavedResetToken(string $path): void
    {
        if (!$this->resetToken) {
            throw new RuntimeException('Токен не был сохранён');
        }

        $this->doPostRequestWithData($path, ['reset_token' => $this->resetToken]);
    }

    private function saveResetTokenInDatabase(bool $isExpired): void
    {
        $user = $this->getDefaultUser();

        if (!$user) {
            throw new RuntimeException('Пользователь не был сохранён');
        }

        $resetPasswordToken = $this->resetPasswordHelper->generateResetToken($user);

        $this->resetToken = $resetPasswordToken->getToken();

        if ($isExpired) {
            $resetPasswordRequest = $this->resetPasswordRequestRepository->findOneBy(['user' => $user]);

            $resetPasswordRequest->setExpiresAt(
                new DateTimeImmutable('-1 day')
            );

            $this->resetPasswordRequestRepository->save($resetPasswordRequest, true);
        }
    }
}
