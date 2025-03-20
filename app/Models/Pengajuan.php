<?php

namespace App\Models;

use App\Models\User;
use App\Models\Surat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pengajuan extends Model
{
    use HasFactory;
    
    protected $guarded = [];

    protected $table = 'pengajuans';
    
    public function surat()
    {
        return $this->hasOne(Surat::class, 'pengajuan_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
