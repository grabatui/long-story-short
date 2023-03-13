<?php

namespace App\Core\Presentation\Controller\v1\Entity;

use App\Core\Domain\Search\Entity\Enum\SearchEntityTypeEnum;
use App\Core\Presentation\Controller\v1\AbstractController;
use App\Core\Presentation\Formatter\v1\Entity\SearchFormatter;
use App\Core\Presentation\Request\v1\Entity\SearchRequest;
use App\Core\UseCase\Entity\Search\SearchMainEntitiesByTermAndTypeUseCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    public function __construct(
        private readonly SearchMainEntitiesByTermAndTypeUseCase $searchMainEntitiesByTermAndTypeUseCase,
        private readonly SearchFormatter $searchFormatter
    ) {
    }

    #[Route(
        '/api/v1/entity/search',
        name: 'v1_entity_search',
        methods: ['GET']
    )]
    public function __invoke(SearchRequest $request): Response
    {
        $entities = $this->searchMainEntitiesByTermAndTypeUseCase->get(
            $request->getTerm(),
            SearchEntityTypeEnum::from($request->getType())
        );

        return $this->success(
            $this->searchFormatter->format($entities)
        );
    }
}
