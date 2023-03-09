<?php

namespace App\Core\Domain\Common\Translation;

use App\Core\Domain\Common\Translation\Entity\Enum\LanguageEnum;

interface SwitchKeyboardLayoutInterface
{
    public function run(string $string, LanguageEnum $from, LanguageEnum $to): string;
}
