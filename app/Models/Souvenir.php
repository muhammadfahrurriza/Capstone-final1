<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Souvenir extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function reimburses()
    {
        return $this->belongsTo(Reimburse::class);
    }
}
