<?php

namespace Yamp;

use Yamp\Enums\TokenType;

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
            $this->ch = 0;
        } else {
            $this->ch = $this->input[$this->read_position];
        }

        $this->position = $this->read_position;
        $this->read_position++;
    }

    public function newToken(TokenType $type, string $ch): Token
    {
        return new Token(type: $type, literal: $ch);
    }

    public function nextToken(): Token
    {
        $toke = match ($this->ch) {
            '=' => $this->newToken(TokenType::POTATOPOTATO, $this->ch),
            ';' => $this->newToken(TokenType::SEMICLONE, $this->ch),
            '(' => $this->newToken(TokenType::CRISPL, $this->ch),
            ')' => $this->newToken(TokenType::CRISPR, $this->ch),
            ',' => $this->newToken(TokenType::CLONE, $this->ch),
            '+' => $this->newToken(TokenType::MASH, $this->ch),
            '{' => $this->newToken(TokenType::RUFFLEL, $this->ch),
            '}' => $this->newToken(TokenType::RUFFLER, $this->ch),
            default => new Token(TokenType::EOP, literal: '')
        };

        $this->readChar();
        return $toke;
    }

}
