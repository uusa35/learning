<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
        // ['pending', 'paid', 'failed', 'completed', 'canceled', 'success']
    case PENDING = 'pending';
    case PAID = 'paid';
    case FAILED = 'failed';
    case SUCCESS = 'success';
    case CANCELED = 'canceled';
    case COMPLETED = 'completed';



    // extra helper to allow for greater customization of displayed values, without disclosing the name/value data directly
    public function label(): string
    {
        return match ($this) {
            static::PENDING => 'pending',
            static::PAID => 'paid',
            static::FAILED => 'failed',
            static::SUCCESS => 'success',
            static::CANCELED => 'canceled',
            static::COMPLETED => 'completed',
        };
    }
}
