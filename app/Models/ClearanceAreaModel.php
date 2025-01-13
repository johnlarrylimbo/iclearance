<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Model;

class ClearanceAreaModel extends Model
{
    use HasFactory;

    protected $table = 'clearance_area';

    protected $primaryKey = 'clearance_area_id';

    // protected $fillable = [
    //     'code',
    //     'label',
    //     'statuscode'
    // ];

    // public function user(): BelongsToMany
    // {
    //     return $this->belongsToMany(User::class);
    // }

    public function users() {
   
        return $this->setConnection('iclearance_connection')->belongsToMany(User::class,'authorize_employee','clearance_area_id','account_id');
           
    }
}
