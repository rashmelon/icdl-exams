<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return $this->respond('All Records Fetched Successfully', Category::with(['skillsCards', 'subjects'])->get());
    }

    public function store()
    {
        return $this->respond('Created Successfully', Category::create(request()->all()));
    }

    public function update($id)
    {
        $category = Category::find($id);

        $category->update(request()->all());

        return $this->respond('Updated Successfully');
    }

    public function destroy($id)
    {
        Category::find($id)->delete();

        return $this->respond('Deleted Successfully');
    }
}
