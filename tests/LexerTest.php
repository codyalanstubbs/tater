<?php

namespace Yamp\tests;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Yamp\Enums\TokenType;
use Yamp\Lexer\Lexer;

#[UsesClass(Lexer::class)]
#[CoversMethod(Lexer::class, '__construct')]
class LexerTest extends TestCase
{
    #[Test]
    #[TestWith(name: 'assign',              data: ['=', TokenType::POTATOPOTATO])]
    #[TestWith(name: 'plus',                data: ['+', TokenType::MASH])]
    #[TestWith(name: 'parantheses-left',    data: ['(', TokenType::CRISPL])]
    #[TestWith(name: 'parantheses-right',   data: [')', TokenType::CRISPR])]
    #[TestWith(name: 'brace-left',          data: ['{', TokenType::RUFFLEL])]
    #[TestWith(name: 'brace-right',         data: ['}', TokenType::RUFFLER])]
    #[TestWith(name: 'comma',               data: [',', TokenType::CLONE])]
    #[TestWith(name: 'semicolon',           data: [';', TokenType::SEMICLONE])]
    #[TestWith(name: 'end of function',     data: ['',  TokenType::EOP])]
    public function testNextToken($input, $token_enum)
    {
        $lexi = Lexer::new($input);
        $toke = $lexi->nextToken();

        $this->assertEquals($toke->type, $token_enum);
        $this->assertEquals($toke->literal, $token_enum->value);
    }
}
