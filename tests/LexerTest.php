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
    #[TestWith(name: 'basic test', data: [
        '=+(){},;',
        [
            new LexerExpectation(TokenType::ASSIGN, '='),
            new LexerExpectation(TokenType::PLUS, '+'),
            new LexerExpectation(TokenType::LPAREN, '('),
            new LexerExpectation(TokenType::RPAREN, ')'),
            new LexerExpectation(TokenType::LBRACE, '{'),
            new LexerExpectation(TokenType::RBRACE, '}'),
            new LexerExpectation(TokenType::COMMA, ','),
            new LexerExpectation(TokenType::SEMICOLON, ';'),
            new LexerExpectation(TokenType::EOF, ''),
        ]
    ])]
    public function it_reads_next_token(string $input, array $tests)
    {
        $lexi = Lexer::new($input);

        array_map(
            function (LexerExpectation $test) use ($lexi) {
                $toke = $lexi->nextToken();
                $this->assertEquals($toke->type, $test->expected_type);
                $this->assertEquals($toke->literal, $test->expected_literal);
            },
            $tests
        );
    }
}

class LexerExpectation
{
    public function __construct(
        public readonly TokenType $expected_type,
        public readonly string $expected_literal,
    ) {
    }
}
