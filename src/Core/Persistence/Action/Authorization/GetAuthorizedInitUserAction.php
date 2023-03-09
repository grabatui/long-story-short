<?php

namespace App\Core\Persistence\Action\Authorization;

use App\Core\Domain\Authorization\Entity\UserInit;
use App\Core\Domain\Authorization\GetAuthorizedInitUserInterface;
use App\Core\Domain\Common\Exception\NotFoundInterfaceException;
use App\Core\Persistence\Model\Authorization\UserModel;
use App\Core\Persistence\Repository\Adapter\SecurityRepository;

readonly class GetAuthorizedInitUserAction implements GetAuthorizedInitUserInterface
{
    public function __construct(
        private SecurityRepository $securityRepository,
        private UserModel $userModel
    ) {
    }

    /**
     * @throws NotFoundInterfaceException
     */
    public function get(): UserInit
    {
        $user = $this->securityRepository->getUser();

        if (!$user) {
            throw new NotFoundInterfaceException('User is not authorized');
        }

        return $this->userModel->toDomainInit($user);
    }
}
