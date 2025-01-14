<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountRole extends Model
{
    use HasFactory;

    protected $table = 'account_role';

    protected $primaryKey = 'account_role_id';

    public function user(): BelongsTo
    {
      $this->belongsTo(User::class, 'account_id');
    }
}
