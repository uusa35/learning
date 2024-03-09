<?php

namespace App\Enums;

enum UserBloodTypeEnum: string
{
        // ['A', 'B', 'A+', 'A-', 'AB', 'O-', 'O+', 'B+', 'B-', 'AB+', 'AB-']
    case A = 'A';
    case B = ' B';
    case A_PLUS = 'A+';
    case A_MINUS = 'A-';
    case AB = 'AB';
    case O_MINUS = 'O-';
    case O_PLUS = 'O+';
    case B_PLUS = 'B+';
    case B_MINUS = 'B-';
    case A_BPLUS = 'B+';
    case A_BMINUS = 'B-';



    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::A => 'A',
            static::B => ' B',
            static::A_PLUS => 'A+',
            static::A_MINUS => 'A-',
            static::AB => 'AB',
            static::O_MINUS => 'O-',
            static::O_PLUS => 'O+',
            static::B_PLUS => 'B+',
            static::B_MINUS => 'B-',
            static::A_BPLUS => 'B+',
            static::A_BMINUS => 'B-',
        };
    }
}
