<?php

namespace App\Enums;

enum OrdePaymentMethodEnum: string
{
    case KNET = 'pending';
    case VISA = 'paid';
    case CASH = 'failed';

    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            self::KNET => 'pending',
            self::VISA => 'paid',
            self::CASH => 'failed',
        };
    }

    public function keyLabels(): array
    {
        return array_reduce(self::cases(), function ($carry,  $item) {
            $carry[$item->value] = $item->label();
            return $carry;
        }, []);
    }
}
