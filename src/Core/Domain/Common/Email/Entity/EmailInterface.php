<?php

namespace App\Core\Domain\Common\Email\Entity;

interface EmailInterface
{
    public function getFrom(): string;
    public function getTo(): string;
    public function getSubject(): string;
    public function getContext(): array;
}
