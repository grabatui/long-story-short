<?php

namespace App\Tests\Feature\v1\Entity\SearchTest;

use App\Core\Persistence\Repository\MovieRepository;
use App\Core\Persistence\Repository\UserRepository;
use App\Tests\Feature\AbstractFeatureContext;
use App\Tests\Feature\Traits\ElasticaTrait;
use App\Tests\Feature\Traits\EntityTrait;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class FeatureContext extends AbstractFeatureContext
{
    use ElasticaTrait;
    use EntityTrait;

    public function __construct(
        JWTEncoderInterface $JWTEncoder,
        UserPasswordHasherInterface $hasher,
        UserRepository $userRepository,
        protected MovieRepository $movieRepository
    ) {
        parent::__construct($JWTEncoder, $hasher, $userRepository);
    }

    /**
     * @Then /^в ответе (.*) элемент((?:ов|а)?)$/
     */
    public function a()
    {

    }
}
