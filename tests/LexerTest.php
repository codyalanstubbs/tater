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
            new LexerExpectation(TokenType::POTATOPOTATO, '='),
            new LexerExpectation(TokenType::MASH, '+'),
            new LexerExpectation(TokenType::CRISPL, '('),
            new LexerExpectation(TokenType::CRISPR, ')'),
            new LexerExpectation(TokenType::RUFFLEL, '{'),
            new LexerExpectation(TokenType::RUFFLER, '}'),
            new LexerExpectation(TokenType::CLONE, ','),
            new LexerExpectation(TokenType::SEMICLONE, ';'),
            new LexerExpectation(TokenType::EOP, ''),
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
