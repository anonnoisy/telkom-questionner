<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponseChoice extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'alpha_choice', 'choice'];

    public function question() {
        return $this->belongsTo(Question::class);
    }
}
