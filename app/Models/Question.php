<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'question'
    ];

    public function survey() {
        return $this->hasMany(Survey::class);
    }

    public function question_types() {
        return $this->hasMany(QuestionType::class);
    }

    public function question_choices() {
        return $this->hasMany(ResponseChoice::class);
    }
}
