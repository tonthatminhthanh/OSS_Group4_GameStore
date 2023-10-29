<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheLoai extends Model
{
    use HasFactory;

    protected $table = "the_loai";

    protected $fillable = [
        "name"
    ];

    public function mat_hang()
    {
        return $this->hasMany(MatHang::class, "the_loai");
    }
}
