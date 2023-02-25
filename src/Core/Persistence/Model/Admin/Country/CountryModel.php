<?php

namespace App\Core\Persistence\Model\Admin\Country;

use App\Core\Domain\Admin\Country\Entity\Country as DomainCountry;
use App\Core\Persistence\Entity\Country;

class CountryModel
{
    public function toDomain(Country $databaseCountry): DomainCountry
    {
        return new DomainCountry(
            $databaseCountry->getCode(),
            $databaseCountry->getTitle()
        );
    }
}
