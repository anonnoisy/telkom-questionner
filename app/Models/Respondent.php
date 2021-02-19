<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Respondent extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'nik',
        'objid_posisi',
        'jabatan',
        'band',
        'lokasi_kerja',
        'sub_unit',
        'unit',
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

    public function survey_responses() {
        return $this->hasMany(SurveyResponse::class);
    }

    public function responses() {
        return $this->hasMany(Survey::class);
    }

    public function groups() {
        return $this->belongsToMany(Group::class, 'respondent_groups');
    }
}
