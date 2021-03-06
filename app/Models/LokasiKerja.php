<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LokasiKerja extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function respondents() {
        return $this->hasMany(Respondent::class);
    }
}
