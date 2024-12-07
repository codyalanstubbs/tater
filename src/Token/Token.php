<?php

namespace Yamp\Token;

use Yamp\Enums\TokenType;

class Token
{
    public TokenType $type;
    public string $literal;

    public function __construct(TokenType $type, string $literal)
    {
        $this->type = $type;
        $this->literal = $literal;
    }
}

