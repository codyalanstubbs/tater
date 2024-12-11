<?php

namespace Yamp\Token;

use Yamp\Enums\TokenType;

class Token
{
    public function __construct(
        public ?TokenType $type = null,
        public ?string $literal = null,
    ) {}

    private $keywords = [
        'tater' => TokenType::FUNCTION,
        'tt'    => TokenType::LET,
    ];

    public function lookupIdent(string $ident): TokenType
    {
        if (array_key_exists($ident, $this->keywords)) {
            return $this->keywords[$ident];
        }
        return TokenType::IDENT;
    }
}

