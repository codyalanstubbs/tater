<?php

namespace Yamp\Enums;

enum TokenType: string
{
    case ILLEGAL = "ILLEGAL";
    case EOF     = "EOF";

    // Identifiers + literals
    case IDENT = "IDENT"; // add, foobar, x, y, ...
    case INT   = "INT";   // 1343456

    // Operators
    case ASSIGN   = "=";
    case PLUS     = "+";

    // Delimiters
    case COMMA     = ",";
    case SEMICOLON = ";";

    case LPAREN = "(";
    case RPAREN = ")";
    case LBRACE = "{";
    case RBRACE = "}";

    // Keywords
    case FUNCTION = "FUNCTION";
    case LET      = "LET";
}

