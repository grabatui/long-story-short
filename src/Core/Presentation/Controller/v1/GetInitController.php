<?php

namespace App\Core\Presentation\Controller\v1;

use App\Core\Presentation\Entity\Enum\SearchTypeEnum;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GetInitController extends AbstractController
{
    #[Route(
        '/api/v1/init',
        name: 'v1_init'
    )]
    public function __invoke(): Response
    {
        return $this->success([
            'search_types' => $this->makeSearchTypes(),
        ]);
    }

    private function makeSearchTypes(): array
    {
        return array_map(
            static fn (SearchTypeEnum $type): array => [
                'type' => $type->name,
                'title' => $type->value,
                'placeholder' => $type->getPlaceholder(),
            ],
            SearchTypeEnum::cases()
        );
    }
}
