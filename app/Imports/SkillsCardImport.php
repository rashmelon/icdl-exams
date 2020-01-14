<?php

namespace App\Imports;

use App\SkillsCard;
use Maatwebsite\Excel\Concerns\ToModel;

class SkillsCardImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $skill  = SkillsCard::where('number', $row[1])->first();
        if ($row[1] && !$skill)
            return new SkillsCard([
                'number' => $row[1],
                'used' => 0,
                'category_id' => 3
            ]);
    }
}
