<?php

namespace App\Core\Persistence\Action\Admin\Country;

use App\Core\Domain\Admin\Country\Entity\Country as DomainCountry;
use App\Core\Domain\Admin\Country\GetAllCountriesSortedByTitleInterface;
use App\Core\Persistence\Entity\Country;
use App\Core\Persistence\Model\Admin\Country\CountryModel;
use App\Core\Persistence\Repository\CountryRepository;

readonly class GetAllCountriesSortedByTitleAction implements GetAllCountriesSortedByTitleInterface
{
    public function __construct(
        private CountryRepository $countryRepository,
        private CountryModel $countryModel
    ) {
    }

    public function get(): array
    {
        return array_map(
            fn (Country $country): DomainCountry => $this->countryModel->toDomain($country),
            $this->countryRepository->getAllSortedByTitle()
        );
    }
}
