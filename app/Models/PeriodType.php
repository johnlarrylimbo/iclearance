<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeriodType extends Model
{
    use HasFactory;

    protected $table = 'period_type';

    protected $primaryKey = 'period_type_id';
}
