<?php

namespace App\Core\Domain\Common\Email;

use App\Core\Domain\Common\Email\Entity\EmailInterface;

interface SendEmailInterface
{
    public function run(EmailInterface $email): void;
}
