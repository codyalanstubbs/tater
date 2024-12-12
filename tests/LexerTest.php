<?php

namespace Yamp\tests;

use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestWith;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use Yamp\Lexer\Lexer;
use Yamp\Token\Token;

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
            new LexerExpectation(Token::LET, 'tt'),
            new LexerExpectation(Token::IDENT, 'five'),
            new LexerExpectation(Token::ASSIGN, '='),
            new LexerExpectation(Token::INT, '5'),
            new LexerExpectation(Token::SEMICOLON, ';'),
            new LexerExpectation(Token::LET, 'tt'),
            new LexerExpectation(Token::IDENT, 'ten'),
            new LexerExpectation(Token::ASSIGN, '='),
            new LexerExpectation(Token::INT, '10'),
            new LexerExpectation(Token::SEMICOLON, ';'),
            new LexerExpectation(Token::LET, 'tt'),
            new LexerExpectation(Token::IDENT, 'add'),
            new LexerExpectation(Token::ASSIGN, '='),
            new LexerExpectation(Token::FUNCTION, 'tater'),
            new LexerExpectation(Token::LPAREN, '('),
            new LexerExpectation(Token::IDENT, 'x'),
            new LexerExpectation(Token::COMMA, ','),
            new LexerExpectation(Token::IDENT, 'y'),
            new LexerExpectation(Token::RPAREN, ')'),
            new LexerExpectation(Token::LBRACE, '{'),
            new LexerExpectation(Token::IDENT, 'x'),
            new LexerExpectation(Token::PLUS, '+'),
            new LexerExpectation(Token::IDENT, 'y'),
            new LexerExpectation(Token::SEMICOLON, ';'),
            new LexerExpectation(Token::RBRACE, '}'),
            new LexerExpectation(Token::SEMICOLON, ';'),
            new LexerExpectation(Token::LET, 'tt'),
            new LexerExpectation(Token::IDENT, 'result'),
            new LexerExpectation(Token::ASSIGN, '='),
            new LexerExpectation(Token::IDENT, 'add'),
            new LexerExpectation(Token::LPAREN, '('),
            new LexerExpectation(Token::IDENT, 'five'),
            new LexerExpectation(Token::COMMA, ','),
            new LexerExpectation(Token::IDENT, 'ten'),
            new LexerExpectation(Token::RPAREN, ')'),
            new LexerExpectation(Token::SEMICOLON, ';'),
            new LexerExpectation(Token::EOF, ''),
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
        public readonly string $expected_type,
        public readonly string $expected_literal,
    ) {
    }
}
