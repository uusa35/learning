<?php

namespace App\Models;

use App\Services\Traits\ImageHelpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PrimaryModel extends Model
{
    use  ImageHelpers, ModelHelpers, HasFactory;
}
