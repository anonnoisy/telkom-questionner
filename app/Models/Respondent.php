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
        'lokasi_kerja_id',
        'sub_unit_id',
        'unit_id',
        'unit_name'
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
        return $this->hasMany(Response::class);
    }

    public function groups() {
        return $this->belongsToMany(Group::class, 'respondent_groups');
    }

    public function getUnitNameAttribute() {
        return $this->unit->name;
    }

    public function lokasi_kerja() {
        return $this->belongsTo(LokasiKerja::class);
    }

    public function sub_unit() {
        return $this->belongsTo(SubUnit::class);
    }

    public function unit() {
        return $this->belongsTo(Unit::class);
    }
}
