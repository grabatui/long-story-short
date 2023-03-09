<?php

namespace App\Core\Persistence\Action\Common\Translation;

use App\Core\Domain\Common\Translation\Entity\Enum\LanguageEnum;
use App\Core\Domain\Common\Translation\SwitchKeyboardLayoutInterface;

readonly class SwitchKeyboardLayoutAction implements SwitchKeyboardLayoutInterface
{
    private const MAP = [
        [
            LanguageEnum::en,
            LanguageEnum::ru,
            [
                '@' => '"', '#' => '№', '$' => ';', '%' => '%', '^' => ':', '&' => '?', '`' => 'ё', 'q' => 'й',
                'w' => 'ц', 'e' => 'у', 'r' => 'к', 't' => 'е', 'y' => 'н', 'u' => 'г', 'i' => 'ш', 'o' => 'щ',
                'p' => 'з', '[' => 'х', ']' => 'ъ', 'a' => 'ф', 's' => 'ы', 'd' => 'в', 'f' => 'а', 'g' => 'п',
                'h' => 'р', 'j' => 'о', 'k' => 'л', 'l' => 'д', ';' => 'ж', '\'' => 'э', 'z' => 'я', 'x' => 'ч',
                'c' => 'с', 'v' => 'м', 'b' => 'и', 'n' => 'т', 'm' => 'ь', ',' => 'б', '.' => 'ю', '/' => '.',
                'Q' => 'Й', 'W' => 'Ц', 'E' => 'У', 'R' => 'К', 'T' => 'Е', 'Y' => 'Н', 'U' => 'Г', 'I' => 'Ш',
                'O' => 'Щ', 'P' => 'З', '{' => 'Х', '}' => 'Ъ', 'A' => 'Ф', 'S' => 'Ы', 'D' => 'В', 'F' => 'А',
                'G' => 'П', 'H' => 'Р', 'J' => 'О', 'K' => 'Л', 'L' => 'Д', ':' => 'Ж', '"' => 'Э', 'Z' => 'Я',
                'X' => 'Ч', 'C' => 'С', 'V' => 'М', 'B' => 'И', 'N' => 'Т', 'M' => 'Ь', '<' => 'Б', '>' => 'Ю',
                '?' => ',',
            ],
        ],
    ];

    public function run(string $string, LanguageEnum $from, LanguageEnum $to): string
    {
        foreach (self::MAP as $variant) {
            if (
                ($from === $variant[0] && $to === $variant[1])
                || ($from === $variant[1] && $to === $variant[0])
            ) {
                return strtr(
                    $string,
                    $from === $variant[0] ? $variant[2] : array_flip($variant[2])
                );
            }
        }

        return $string;
    }
}
