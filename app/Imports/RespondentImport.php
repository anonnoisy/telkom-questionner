<?php

namespace App\Imports;

use App\Models\Respondent;
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

        $respondent = Respondent::create([
            'name' => $row[2],
            'nik' => $row[1],
            'objid_posisi' => $row[3],
            'jabatan' => $row[4],
            'band' => $row[5],
            'lokasi_kerja' => $row[6],
            'sub_unit' => $row[7],
            'unit' => $row[8],
        ]);

        $this->group->respondents()->detach();
        $this->group->respondents()->attach($respondent->id);

        return $respondent;
    }
}