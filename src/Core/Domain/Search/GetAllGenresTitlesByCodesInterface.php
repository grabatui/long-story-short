<?php

namespace App\Core\Domain\Search;

interface GetAllGenresTitlesByCodesInterface
{
    /**
     * @return array<string, string>
     */
    public function get(): array;
}
