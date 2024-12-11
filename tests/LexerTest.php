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
        'tt five = 5;
        tt ten = 10;

        tt add = tater(x, y) {
            x + y;
        };

        tt result = add(five, ten);
        ',
        [
            new LexerExpectation(TokenType::LET, 'tt'),
            new LexerExpectation(TokenType::IDENT, 'five'),
            new LexerExpectation(TokenType::ASSIGN, '='),
            new LexerExpectation(TokenType::INT, '5'),
            new LexerExpectation(TokenType::SEMICOLON, ';'),
            new LexerExpectation(TokenType::LET, 'tt'),
            new LexerExpectation(TokenType::IDENT, 'ten'),
            new LexerExpectation(TokenType::ASSIGN, '='),
            new LexerExpectation(TokenType::INT, '10'),
            new LexerExpectation(TokenType::SEMICOLON, ';'),
            new LexerExpectation(TokenType::LET, 'tt'),
            new LexerExpectation(TokenType::IDENT, 'add'),
            new LexerExpectation(TokenType::ASSIGN, '='),
            new LexerExpectation(TokenType::FUNCTION, 'tater'),
            new LexerExpectation(TokenType::LPAREN, '('),
            new LexerExpectation(TokenType::IDENT, 'x'),
            new LexerExpectation(TokenType::COMMA, ','),
            new LexerExpectation(TokenType::IDENT, 'y'),
            new LexerExpectation(TokenType::RPAREN, ')'),
            new LexerExpectation(TokenType::LBRACE, '{'),
            new LexerExpectation(TokenType::IDENT, 'x'),
            new LexerExpectation(TokenType::PLUS, '+'),
            new LexerExpectation(TokenType::IDENT, 'y'),
            new LexerExpectation(TokenType::SEMICOLON, ';'),
            new LexerExpectation(TokenType::RBRACE, '}'),
            new LexerExpectation(TokenType::SEMICOLON, ';'),
            new LexerExpectation(TokenType::LET, 'tt'),
            new LexerExpectation(TokenType::IDENT, 'result'),
            new LexerExpectation(TokenType::ASSIGN, '='),
            new LexerExpectation(TokenType::IDENT, 'add'),
            new LexerExpectation(TokenType::LPAREN, '('),
            new LexerExpectation(TokenType::IDENT, 'five'),
            new LexerExpectation(TokenType::COMMA, ','),
            new LexerExpectation(TokenType::IDENT, 'ten'),
            new LexerExpectation(TokenType::RPAREN, ')'),
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
                $this->assertEquals($test->expected_type, $toke->type);
                $this->assertEquals($test->expected_literal, $toke->literal);
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
