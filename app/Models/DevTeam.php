<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DevTeam extends Model
{
    use HasFactory;

    protected $table = "dev_team";

    protected $fillable = [
        "dev_name", "avatar"
    ];

    public function mat_hang()
    {
        return $this->hasMany(MatHang::class, "dev_id");
    }
}
