
<?php

namespace App\Enums;

enum RolesEnum: string
{
        // case NAMEINAPP = 'name-in-database';
    case PATINET = 'patient';
    case DOCTOR = 'doctor';
    case ADMIN = 'admin';
    case SUPER = 'super';
    case RECEPTIONIST = 'receptionist';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::PATINET => 'patient',
            static::DOCTOR => 'doctor',
            static::ADMIN => 'admin',
            static::SUPER => 'super',
            static::RECEPTIONIST => 'receptionist',
        };
    }
}

?>
