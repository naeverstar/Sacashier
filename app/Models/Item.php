<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /* RELASI */
    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function detail() {
        return $this->hasMany(TransactionDetail::class);
    }
}
