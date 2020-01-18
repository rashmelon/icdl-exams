<?php

namespace App\Imports;

use App\Candidate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class PhoneAndTestsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return Model|Model[]|null
     */
    public function model(array $row)
    {
        if ($row[0]){

            $candidate = Candidate::whereHas('skillsCard', function ($query) use ($row) {
                $query->where('number', $row[0]);
            })->first();

            if ($candidate){
                $candidate->update([
                    'mobile1' => $row[1],
                    'tests' => $row[2]? :0,
                    'absence' => (int)$row[3],
                    'certificate_state' => strtolower(trim($row[4])),
                    'finished' => $row[4]? 1:0,
                ]);
            }
        }
    }
}
