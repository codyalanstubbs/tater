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
            TokenType::POTATOPOTATO,
            TokenType::MASH,
            TokenType::CRISPL,
            TokenType::CRISPR,
            TokenType::RUFFLEL,
            TokenType::RUFFLER,
            TokenType::CLONE,
            TokenType::SEMICLONE,
            TokenType::EOP,
        ]
    ])]
    public function it_reads_next_token($input, $tests)
    {
        $lexi = Lexer::new($input);

        array_map(
            function ($test) use ($lexi) {
                $toke = $lexi->nextToken();
                $this->assertEquals($toke->type, $test);
                $this->assertEquals($toke->literal, $test->value);
            },
            $tests
        );
    }
}
