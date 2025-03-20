<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reimburse extends Model
{
    // protected $table = 'reimburses';
    protected $guarded = [];
    use HasFactory;

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bbm()
    {
        return $this->belongsTo(Bbm::class, 'bbm_id');
    }

    public function souvenir()
    {
        return $this->hasMany(Souvenir::class, 'reimburse_id');
    }
}
