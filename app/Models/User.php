<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasPermissionsTrait;

    protected $table = 'user_account';

    protected $primaryKey = 'user_account_id';

    protected $guard_name = 'web';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'email_address',
        'password'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // protected  $appends = [
    //     'clearance_area'
    // ];

    public function roles()
    {
        return $this->setConnection('iclearance_connection')->belongsToMany(Role::class,'account_role','account_id','role_id');
    }

    public function clearance_areas()
    {
        return $this->setConnection('iclearance_connection')->belongsToMany(ClearanceArea::class,'authorize_employee','account_id','clearance_area_id');
    }

    // public function getClearanceAttribute()
    // {
    //     return $this->clearance_areas->first();
    // }

    // public function profile()
    // {
    //   return $this->hasOne(Student::class, 'account_id', 'account_id');
    // }

    // public function profile_parent_login()
    // {
    //   return $this->hasOne(Student::class, 'parent_account_id', 'account_id');
    // }

    // public function teacher_profile()
    // {
    //   return $this->hasOne(Teacher::class, 'account_id', 'account_id');
    // }

}
