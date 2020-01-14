<?php

namespace App\Imports;

use App\Candidate;
use App\SkillsCard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;

class CandidateImport implements ToModel
{

    /**
     * @param array $row
     *
     * @return Model|Model[]|null
     */
    public function model(array $row)
    {
        $skill = SkillsCard::where('number', $row[1])->first();

        if (!$skill){
            $skill = new SkillsCard([
                'number' => $row[1],
                'used' => 1,
                'category_id' => 1
            ]);
        }

        if ($row[0]){
            $skill->used = 1;
            $skill->save();

            Candidate::create([
                'national_id' => $row[0],
                'english_name' => $row[2],
                'arabic_name' => $row[3],
                'skills_card_id' => $skill->id,
            ]);
        }
    }
}
