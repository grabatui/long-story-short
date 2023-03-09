<?php

namespace App\Core\Presentation\Request\v1\Entity;

use App\Core\Presentation\Entity\Enum\SearchTypeEnum;
use App\Core\Presentation\Request\AbstractRequest;
use DigitalRevolution\SymfonyRequestValidation\ValidationRules;

class SearchRequest extends AbstractRequest
{
    protected function getValidationRules(): ?ValidationRules
    {
        return new ValidationRules([
            'request' => [
                'type' => [
                    'required',
                    'in:' . $this->getSearchTypes(),
                ],
                'term' => 'required|max:100',
            ],
        ]);
    }

    public function getType(): string
    {
        return $this->getRequest()->request->get('type');
    }

    public function getTerm(): string
    {
        return $this->getRequest()->request->get('term');
    }

    private function getSearchTypes(): string
    {
        $searchTypes = array_map(
            static fn (SearchTypeEnum $searchType): string => $searchType->name,
            SearchTypeEnum::cases()
        );

        return implode(',', $searchTypes);
    }
}
