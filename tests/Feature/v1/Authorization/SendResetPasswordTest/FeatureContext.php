<?php

namespace App\Tests\Feature\v1\Authorization\SendResetPasswordTest;

use App\Tests\Feature\AbstractFeatureContext;
use App\Tests\Feature\Traits\EmailTrait;

class FeatureContext extends AbstractFeatureContext
{
    use EmailTrait;
}
