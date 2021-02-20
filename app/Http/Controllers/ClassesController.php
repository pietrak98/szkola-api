<?php

namespace App\Http\Controllers;

use App\Models\ClassSchool;
use Illuminate\Http\Request;

class ClassesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ClassSchool::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return ClassSchool::create(['name' => $request->name]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ClassSchool  $classSchool
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClassSchool $classSchool)
    {
        $classSchool->update(['name' => $request->name]);

        return $classSchool;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ClassSchool  $classSchool
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClassSchool $classSchool)
    {
        $classSchool->delete();
        return $classSchool;
    }
}
