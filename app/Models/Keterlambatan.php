<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keterlambatan extends Model
{
    protected $guarded = [];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function kehadiran()
    {
        return $this->belongsTo(Kehadiran::class, 'kehadiran_id');
    }
}
