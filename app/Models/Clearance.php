<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clearance extends Model
{
    use HasFactory;

    protected $table = 'clearance';

    protected $primaryKey = 'clearance_id';

    public function clearance()
    {
      return $this->setConnection('iclearance_connection')->belongsToMany(Clearance::class, 'clearance_id', 'clearance_id');
    }

    public static function showCompanyName($status){
        $companyName=Clearance::query()
        ->where('is_open', $status)->first()->clearance_id;
        return $companyName;
    }
}
