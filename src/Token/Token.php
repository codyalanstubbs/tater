<?php

namespace Yamp\Token;

use Yamp\Enums\TokenType;

class Token
{
    const ILLEGAL = "ILLEGAL";
    const EOF     = "EOF";

    // Identifiers + literals
    const IDENT = "IDENT"; // add, foobar, x, y, ...
    const INT   = "INT";   // 1343456

    // Operators
    const ASSIGN   = "=";
    const PLUS     = "+";

    // Delimiters
    const COMMA     = ",";
    const SEMICOLON = ";";

    const LPAREN = "(";
    const RPAREN = ")";
    const LBRACE = "{";
    const RBRACE = "}";

    // Keywords
    const FUNCTION = "FUNCTION";
    const LET      = "LET";

    public function __construct(
        public ?string $type = null,
        public ?string $literal = null,
    ) {}

    private $keywords = [
        'tater' => Token::FUNCTION,
        'tt'    => Token::LET,
    ];

    public function lookupIdent(string $ident): string
    {
        if (array_key_exists($ident, $this->keywords)) {
            return $this->keywords[$ident];
        }
        return Token::IDENT;
    }
}

