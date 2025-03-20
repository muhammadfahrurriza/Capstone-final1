<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    protected $guarded = [];
    
    public function books()
    {
        return $this->belongsToMany(BookModel::class, 'mobil_book', 'mobil_id', 'buku_id');
    }

    public function getBookTitlesAttribute()
    {
        return $this->books()->pluck('judul')->implode(', ');
    }
}
