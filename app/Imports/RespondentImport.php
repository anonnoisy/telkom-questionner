<?php

namespace App\Imports;

use App\Models\LokasiKerja;
use App\Models\Respondent;
use App\Models\SubUnit;
use App\Models\Unit;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class RespondentImport implements ToModel
{
    protected $group;

    public function __construct($group)
    {
        $this->group = $group;
    }

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {
        if ($row[0] == 'NO') {
            return null;
        }

        $lokasi_kerja = LokasiKerja::where('name', $row[6])->first();
        if (empty($lokasi_kerja)) {
            $lokasi_kerja = LokasiKerja::create(['name' => $row[6]]);
        }

        $sub_unit = SubUnit::where('name', $row[7])->first();
        if (empty($sub_unit)) {
            $sub_unit = SubUnit::create(['name' => $row[7]]);
        }

        $unit = Unit::where('name', $row[8])->first();
        if (empty($unit)) {
            $unit = Unit::create(['name' => $row[8]]);
        }

        $respondent = Respondent::create([
            'name' => $row[2],
            'nik' => $row[1],
            'objid_posisi' => $row[3],
            'jabatan' => $row[4],
            'band' => $row[5],
            'lokasi_kerja_id' => $lokasi_kerja->id,
            'sub_unit_id' => $sub_unit->id,
            'unit_id' => $unit->id,
        ]);

        $this->group->respondents()->detach($respondent->id);
        $this->group->respondents()->attach($respondent->id);

        return $respondent;
    }
}