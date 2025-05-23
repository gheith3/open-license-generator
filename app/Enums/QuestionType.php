<?php

namespace App\Enums;

enum QuestionType: string
{
    case RADIO = 'radio';
    case CHECKBOX = 'checkbox';
    case BOOLEAN = 'boolean';
}
