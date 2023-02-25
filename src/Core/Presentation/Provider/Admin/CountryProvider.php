<?php

namespace App\Core\Presentation\Provider\Admin;

use App\Core\Domain\Admin\Country\Entity\Country;
use App\Core\Domain\Admin\Country\GetAllCountriesSortedByTitleInterface;

readonly class CountryProvider
{
    public function __construct(
        private GetAllCountriesSortedByTitleInterface $getAllCountriesSortedByTitle
    ) {
    }

    /**
     * @return Country[]
     */
    public function getAllSortedByTitle(): array
    {
        return $this->getAllCountriesSortedByTitle->get();
    }
}
