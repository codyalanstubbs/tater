<?php

namespace Yamp\Lexer;

use Yamp\Enums\TokenType;
use Yamp\Token\Token;

class Lexer
{
    public string           $input;
    public int | null       $position       = 0;    // current poistion in input (points to current char)
    public int              $read_position  = 0;    // current reading position in input (after current)
    public string | null    $ch             = null; // current char under examination

    public function __construct($input)
    {
        $this->input = $input;
    }

    public static function new(string $input): Lexer
    {
        $lexi = new Lexer(input: $input);
        $lexi->readChar();
        return $lexi;
    }

    public function readChar()
    {
        if ($this->read_position >= strlen($this->input)) {
            $this->ch = null;
        } else {
            $this->ch = $this->input[$this->read_position];
        }

        $this->position = $this->read_position;
        $this->read_position++;
    }

    public function nextToken(): Token
    {
        $toke = match ($this->ch) {
            '=' => new Token(TokenType::ASSIGN, $this->ch),
            ';' => new Token(TokenType::SEMICOLON, $this->ch),
            '(' => new Token(TokenType::LPAREN, $this->ch),
            ')' => new Token(TokenType::RPAREN, $this->ch),
            ',' => new Token(TokenType::COMMA, $this->ch),
            '+' => new Token(TokenType::PLUS, $this->ch),
            '{' => new Token(TokenType::LBRACE, $this->ch),
            '}' => new Token(TokenType::RBRACE, $this->ch),
            null   => new Token(TokenType::EOF, '')
        };

        $this->readChar();
        return $toke;
    }

}
