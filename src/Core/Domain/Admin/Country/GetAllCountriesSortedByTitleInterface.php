<?php

namespace App\Core\Domain\Admin\Country;

use App\Core\Domain\Admin\Country\Entity\Country;

interface GetAllCountriesSortedByTitleInterface
{
    /**
     * @return Country[]
     */
    public function get(): array;
}
