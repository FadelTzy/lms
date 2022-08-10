<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pembelajaran extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function oDosen()
    {
        return $this->hasOne(User::class, 'id', 'id_user');
    }
    public function oMitra()
    {
        return $this->hasOne(User::class, 'id', 'mitra');
    }
    public function oMatkul()
    {
        return $this->hasOne(Matakuliah::class, 'id', 'id_matkul');
    }
}
