<?php

namespace App\Tests\Unit\UseCase\Authorization;

use App\Core\Domain\Authorization\Entity\NewUser;
use App\Core\Domain\Authorization\RegisterUserInterface;
use App\Core\Domain\Common\Exception\CriticalInterfaceException;
use App\Core\Domain\Common\User\IsUserAuthorizedInterface;
use App\Core\Domain\Common\User\MakePasswordHashInterface;
use App\Core\UseCase\Authorization\RegisterUserUseCase;
use PHPUnit\Framework\TestCase;

class RegisterUserUseCaseTest extends TestCase
{
    private const PASSWORD = 'testPassword';
    private const HASHED_PASSWORD = 'testHashedPassword';

    /**
     * @throws CriticalInterfaceException
     */
    public function testHappyPath(): void
    {
        $newUser = $this->makeNewUser(self::PASSWORD);

        $useCase = new RegisterUserUseCase(
            $this->makeIsUserAuthorizedAction(false),
            $this->makeMakePasswordHashAction(self::PASSWORD, self::HASHED_PASSWORD),
            $this->makeRegisterUserAction($newUser, self::HASHED_PASSWORD)
        );

        $useCase->run($newUser);
    }

    public function testUserIsAuthorized(): void
    {
        $newUser = $this->makeNewUser(self::PASSWORD, false);

        $useCase = new RegisterUserUseCase(
            $this->makeIsUserAuthorizedAction(true),
            $this->makeMakePasswordHashAction(self::PASSWORD, self::HASHED_PASSWORD, false),
            $this->makeRegisterUserAction($newUser, self::HASHED_PASSWORD, false)
        );

        $this->expectException(CriticalInterfaceException::class);

        $useCase->run($newUser);
    }

    private function makeNewUser(string $password, bool $getPasswordCallExpected = true): NewUser
    {
        $mock = $this->createMock(NewUser::class);
        $mock
            ->expects($getPasswordCallExpected ? self::once() : self::never())
            ->method('getPassword')
            ->willReturn($password);

        return $mock;
    }

    private function makeIsUserAuthorizedAction(
        bool $return,
        bool $isCallExpected = true
    ): IsUserAuthorizedInterface {
        $mock = $this->createMock(IsUserAuthorizedInterface::class);
        $mock
            ->expects($isCallExpected ? self::once() : self::never())
            ->method('is')
            ->willReturn($return);

        return $mock;
    }

    private function makeMakePasswordHashAction(
        string $password,
        string $return,
        bool $runCallExpected = true
    ): MakePasswordHashInterface {
        $mock = $this->createMock(MakePasswordHashInterface::class);
        $mock
            ->expects($runCallExpected ? self::once() : self::never())
            ->method('run')
            ->with($password)
            ->willReturn($return);

        return $mock;
    }

    private function makeRegisterUserAction(
        NewUser $user,
        string $hashedPassword,
        bool $runCallExpected = true
    ): RegisterUserInterface {
        $mock = $this->createMock(RegisterUserInterface::class);
        $mock
            ->expects($runCallExpected ? self::once() : self::never())
            ->method('run')
            ->with($user, $hashedPassword);

        return $mock;
    }
}
