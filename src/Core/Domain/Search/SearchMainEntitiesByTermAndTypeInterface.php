<?php

namespace App\Core\Domain\Search;

use App\Core\Domain\Search\Entity\Enum\SearchEntityTypeEnum;

interface SearchMainEntitiesByTermAndTypeInterface
{
    /**
     * @param string[] $termVariants
     * @param SearchEntityTypeEnum $type
     * @return array
     */
    public function get(array $termVariants, SearchEntityTypeEnum $type): array;
}
