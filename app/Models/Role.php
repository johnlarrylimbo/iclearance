<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';

    protected $primaryKey = 'role_id';

    public function users() {
   
        return $this->setConnection('iclearance_connection')->belongsToMany(User::class,'account_role','role_id','account_id');
           
    }
}
