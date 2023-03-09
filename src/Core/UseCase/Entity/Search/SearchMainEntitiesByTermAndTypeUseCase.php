<?php

namespace App\Core\UseCase\Entity\Search;

use App\Core\Domain\Common\Exception\CriticalInterfaceException;
use App\Core\Domain\Common\Translation\Entity\Enum\LanguageEnum;
use App\Core\Domain\Common\Translation\SwitchKeyboardLayoutInterface;
use App\Core\Domain\Search\Entity\Enum\SearchEntityTypeEnum;
use App\Core\Domain\Search\Entity\AbstractMainEntity;
use App\Core\Domain\Search\MainEntityFactory;
use App\Core\Domain\Search\SearchMainEntitiesByTermAndTypeInterface;

readonly class SearchMainEntitiesByTermAndTypeUseCase
{
    public function __construct(
        private SearchMainEntitiesByTermAndTypeInterface $searchEntitiesByTermAndType,
        private MainEntityFactory $mainEntityFactory,
        private SwitchKeyboardLayoutInterface $switchKeyboardLayout
    ) {
    }

    /**
     * @param string $term
     * @param SearchEntityTypeEnum $type
     * @return AbstractMainEntity[]
     * @throws CriticalInterfaceException
     */
    public function get(string $term, SearchEntityTypeEnum $type): array
    {
        $termVariants = [
            $this->switchKeyboardLayout->run($term, LanguageEnum::ru, LanguageEnum::en),
            $this->switchKeyboardLayout->run($term, LanguageEnum::en, LanguageEnum::ru),
        ];

        return $this->mainEntityFactory->fromSearchEntities(
            $this->searchEntitiesByTermAndType->get($termVariants, $type)
        );
    }
}
