<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $fillable = [
        'response_id',
        'question_id',
        'respondent_id',
        'answer',
    ];

    public function response() {
        return $this->belongsTo(Response::class);
    }

    public function question() {
        return $this->belongsTo(Question::class);
    }

    public function respondent() {
        return $this->belongsTo(Respondent::class);
    }
}
