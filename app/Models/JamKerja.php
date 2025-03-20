<?php

namespace App\Models;

use App\Models\Surat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JamKerja extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'jam_kerjas';

    public function surat()
    {
        return $this->hasMany(Surat::class, 'jam_kerja_id', 'id');
    }
}
