<?php

namespace App\Http\Controllers;

use App\Imports\CandidateImport;
use App\Imports\PhoneAndTestsImport;
use App\Imports\SkillsCardImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function create(Request $request)
    {
        Excel::import(new PhoneAndTestsImport(), public_path('/storage/New Bundle.xlsx'));
    }
}
