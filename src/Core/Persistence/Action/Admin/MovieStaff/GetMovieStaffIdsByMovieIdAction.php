<?php

namespace App\Core\Persistence\Action\Admin\MovieStaff;

use App\Core\Domain\Admin\MovieStaff\GetMovieStaffIdsByMovieIdInterface;
use App\Core\Persistence\Entity\MovieStaff;
use App\Core\Persistence\Repository\MovieStaffRepository;

readonly class GetMovieStaffIdsByMovieIdAction implements GetMovieStaffIdsByMovieIdInterface
{
    public function __construct(
        private MovieStaffRepository $movieStaffRepository
    ) {
    }

    public function get(int $id): array
    {
        $movieStaffItems = $this->movieStaffRepository->findBy(['movie' => $id]);

        return array_map(
            static fn (MovieStaff $movieStaff): int => $movieStaff->getId(),
            $movieStaffItems
        );
    }
}
