<?php

namespace App\Http\Controllers;

use App\Instruction;
use Illuminate\Http\Request;

class InstructionController extends Controller
{

    public function index()
    {
        return $this->respond('Fetched Successfully', Instruction::all());
    }

    public function store()
    {
        return $this->respond('Created Successfully', Instruction::create(request()->all()));
    }

    public function update($id)
    {
        Instruction::find($id)->update(request()->all());

        return $this->respond('Updated Successfully');
    }

    public function destroy($id)
    {
        Instruction::find($id)->delete();

        return $this->respond('Deleted Successfully');
    }
}
