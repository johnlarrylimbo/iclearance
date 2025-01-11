<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeriodAcademicYear extends Model
{
    use HasFactory;

    protected $table = 'period_academic_year';

    protected $primaryKey = 'period_academic_year_id';
}
