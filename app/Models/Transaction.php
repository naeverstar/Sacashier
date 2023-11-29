<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /* RELASI */
    public function getUser() {
        return $this->belongsTo(User::class);
    }

    public function getDetail() {
        return $this->hasMany(TransactionDetail::class);
    }
}
