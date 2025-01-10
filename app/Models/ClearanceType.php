<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClearanceType extends Model
{
    use HasFactory;

    protected $table = 'clearance_type';

    protected $primaryKey = 'clearance_type_id';
}
