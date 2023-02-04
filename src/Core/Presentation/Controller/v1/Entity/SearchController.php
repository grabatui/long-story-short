<?php

namespace App\Core\Presentation\Controller\v1\Entity;

use App\Core\Presentation\Controller\v1\AbstractController;
use App\Core\Presentation\Request\v1\Entity\SearchRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route(
        '/api/v1/entity/search/',
        name: 'v1_init'
    )]
    public function __invoke(SearchRequest $request): Response
    {
        return $this->success();
    }
}
