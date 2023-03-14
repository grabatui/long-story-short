<?php

namespace App\Tests\Unit\UseCase\User;

use App\Core\Domain\Authorization\Entity\UserInit;
use App\Core\Domain\Authorization\GetAuthorizedInitUserInterface;
use App\Core\Domain\Authorization\UserInitWithAllowsFactory;
use App\Core\Domain\Common\Exception\NotFoundInterfaceException;
use App\Core\UseCase\User\GetAuthorizedUserInitUseCase;
use PHPUnit\Framework\TestCase;

class GetAuthorizedUserInitUseCaseTest extends TestCase
{
    private const USER_INIT_ID = 1;
    private const USER_INIT_EMAIL = 'test@test.test';

    public function testHappyPath(): void
    {
        $userInit = $this->makeUserInit(
            self::USER_INIT_ID,
            self::USER_INIT_EMAIL
        );

        $useCase = new GetAuthorizedUserInitUseCase(
            $this->makeGetAuthorizedInitUserAction(returnUser: $userInit),
            new UserInitWithAllowsFactory()
        );

        $actual = $useCase->get();

        $this->assertEquals(self::USER_INIT_ID, $actual->getId());
        $this->assertEquals(self::USER_INIT_EMAIL, $actual->getEmail());
        $this->assertNotEmpty($actual->getAllows());
    }

    public function testUserIsNotAuthorized(): void
    {
        $useCase = new GetAuthorizedUserInitUseCase(
            $this->makeGetAuthorizedInitUserAction(throwNotFoundException: true),
            new UserInitWithAllowsFactory()
        );

        $result = $useCase->get();

        $this->assertNull($result->getId());
        $this->assertNull($result->getEmail());
        $this->assertEmpty($result->getAllows());
    }

    private function makeUserInit(int $id, string $email): UserInit
    {
        return new UserInit($id, $email);
    }

    private function makeGetAuthorizedInitUserAction(
        ?UserInit $returnUser = null,
        ?bool $throwNotFoundException = null
    ): GetAuthorizedInitUserInterface {
        $mock = $this->createMock(GetAuthorizedInitUserInterface::class);

        if ($returnUser) {
            $mock
                ->expects(self::once())
                ->method('get')
                ->willReturn($returnUser);
        } elseif ($throwNotFoundException) {
            $mock
                ->expects(self::once())
                ->method('get')
                ->willThrowException(new NotFoundInterfaceException());
        }

        return $mock;
    }
}
