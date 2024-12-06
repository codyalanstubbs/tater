<?php

namespace Yamp\Enums;

enum TokenType: string
{
    case BADPOTATO  = "BADPOTATO";
    case EOP        = "";

    // Identifiers + literals
    case GENE       = "GENE";   // add, foobar, x, y, ...
    case POTINT     = "POTINT"; // 1234455

    // Operators
    case POTATOPOTATO   = "=";
    case MASH           = "+";

    // Delimiters
    case CLONE      = ",";
    case SEMICLONE  = ";";

    case CRISPL     = "(";
    case CRISPR     = ")";
    case RUFFLEL    = "{";
    case RUFFLER    = "}";

    // Keywords
    case FUD = "FUD"; // FUNCTION
    case BUD = "BUD"; // LET
}

