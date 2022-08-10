<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function oMateri()
    {
        return $this->hasOne(pembelajaran::class, 'id', 'id_pembelajaran');
    }
}
