<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatHang extends Model
{
    use HasFactory;

    protected $table = "mat_hang";

    protected $fillable = [
        "avatar","ten_mat_hang","mo_ta", "don_gia"
    ];

    public function the_loai()
    {
        return $this->belongsTo(TheLoai::class,"id");
    }

    public function dev_team()
    {
        return $this->belongsTo(DevTeam::class, "id");
    }
}
