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
            new TstExp(Token::LET, 'tt'),
            new TstExp(Token::IDENT, 'five'),
            new TstExp(Token::ASSIGN, '='),
            new TstExp(Token::INT, '5'),
            new TstExp(Token::SEMICOLON, ';'),
            new TstExp(Token::LET, 'tt'),
            new TstExp(Token::IDENT, 'ten'),
            new TstExp(Token::ASSIGN, '='),
            new TstExp(Token::INT, '10'),
            new TstExp(Token::SEMICOLON, ';'),
            new TstExp(Token::LET, 'tt'),
            new TstExp(Token::IDENT, 'add'),
            new TstExp(Token::ASSIGN, '='),
            new TstExp(Token::FUNCTION, 'tater'),
            new TstExp(Token::LPAREN, '('),
            new TstExp(Token::IDENT, 'x'),
            new TstExp(Token::COMMA, ','),
            new TstExp(Token::IDENT, 'y'),
            new TstExp(Token::RPAREN, ')'),
            new TstExp(Token::LBRACE, '{'),
            new TstExp(Token::IDENT, 'x'),
            new TstExp(Token::PLUS, '+'),
            new TstExp(Token::IDENT, 'y'),
            new TstExp(Token::SEMICOLON, ';'),
            new TstExp(Token::RBRACE, '}'),
            new TstExp(Token::SEMICOLON, ';'),
            new TstExp(Token::LET, 'tt'),
            new TstExp(Token::IDENT, 'result'),
            new TstExp(Token::ASSIGN, '='),
            new TstExp(Token::IDENT, 'add'),
            new TstExp(Token::LPAREN, '('),
            new TstExp(Token::IDENT, 'five'),
            new TstExp(Token::COMMA, ','),
            new TstExp(Token::IDENT, 'ten'),
            new TstExp(Token::RPAREN, ')'),
            new TstExp(Token::SEMICOLON, ';'),
            new TstExp(Token::EOF, ''),
        ]
    ])]
    public function it_reads_next_token(string $input, array $tests)
    {
        $lexi = Lexer::new($input);

        array_map(
            function (TstExp $test) use ($lexi) {
                $toke = $lexi->nextToken();
                $this->assertEquals($toke->type, $test->expected_type);
                $this->assertEquals($toke->literal, $test->expected_literal);
            },
            $tests
        );
    }
}

/**
 * Test expectation for lexer testing
*/
class TstExp
{
    public function __construct(
        public readonly string $expected_type,
        public readonly string $expected_literal,
    ) {
    }
}
