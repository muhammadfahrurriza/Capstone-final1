<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjadwalan extends Model
{
    protected $guarded = [];
 
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    
    public function mobils()
    {
        return $this->belongsTo(Mobil::class, 'mobil_id');
    }

    public function surat()
    {
        return $this->belongsTo(Surat::class, 'surat_id');
    }
}
