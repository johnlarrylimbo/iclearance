<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PeriodSemester extends Model
{
    use HasFactory;

    protected $table = 'period_semester';

    protected $primaryKey = 'period_semester_id';
}
