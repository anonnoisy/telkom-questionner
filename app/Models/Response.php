<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Response extends Model
{
    use HasFactory;

    protected $fillable = [
        'survey_id',
        'respondent_id',
        'started_at',
        'completed_at'
    ];

    public function survey() {
        return $this->belongsTo(Survey::class);
    }

    public function respondent() {
        return $this->belongsTo(Respondent::class);
    }
}
