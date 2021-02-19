<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_private',
        'group_id',
        'opening_time',
        'closing_time',
    ];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%'.$search.'%')
                    ->orWhere('nik', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        });
    }

    public function responses() {
        return $this->hasMany(Response::class);
    }

    public function survey_responses() {
        return $this->hasMany(SurveyResponse::class);
    }

    public function questions() {
        return $this->hasMany(Question::class);
    }

    public function group() {
        return $this->belongsTo(Group::class);
    }
}
