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
        $toke = new Token();

        $this->skipWhitespace();

        switch ($this->ch) {
            case '=':
                $toke->type = TokenType::ASSIGN;
                $toke->literal = $this->ch;
                break;
            case ';':
                $toke->type = TokenType::SEMICOLON;
                $toke->literal = $this->ch;
                break;
            case '(':
                $toke->type = TokenType::LPAREN;
                $toke->literal = $this->ch;
                break;
            case ')':
                $toke->type = TokenType::RPAREN;
                $toke->literal = $this->ch;
                break;
            case ',':
                $toke->type = TokenType::COMMA;
                $toke->literal = $this->ch;
                break;
            case '+':
                $toke->type = TokenType::PLUS;
                $toke->literal = $this->ch;
                break;
            case '{':
                $toke->type = TokenType::LBRACE;
                $toke->literal = $this->ch;
                break;
            case '}':
                $toke->type = TokenType::RBRACE;
                $toke->literal = $this->ch;
                break;
            case null:
                $toke = new Token(TokenType::EOF, '');
                break;
            default:
                if (isLetter($this->ch)) {
                    $toke->literal = $this->readIdentifier();
                    $toke->type = $toke->lookupIdent($toke->literal);
                    return $toke;
                } else if (isDigit($this->ch)) {
                    $toke->type = TokenType::INT;
                    $toke->literal = $this->readNumber();
                    return $toke;
                } else {
                    $toke = new Token(TokenType::ILLEGAL, '');
                }
                break;
        };

        $this->readChar();
        return $toke;
    }

    private function readIdentifier(): string
    {
        $position = $this->position;
        while (isLetter($this->ch)) {
            $this->readChar();
        }
        $length = $this->position - $position;
        $offset = $position++;
        return substr($this->input, $offset, $length);
    }

    private function readNumber(): string
    {
        $position = $this->position;
        while (isDigit($this->ch)) {
            $this->readChar();
        }
        $length = $this->position - $position;
        $offset = $position++;
        return substr($this->input, $offset, $length);
    }

    private function skipWhitespace()
    {
        while (is_string($this->ch) && ctype_space($this->ch)) {
            $this->readChar();
        }
    }
}

function isLetter(string $ch): bool
{
    return (bool) ('a' <= $ch && $ch <= 'z' || 'A' <= $ch && $ch <= 'Z' || $ch == '_');
}

function isDigit(string $ch): bool
{
    return '0' <= $ch && $ch <= '9';
}
