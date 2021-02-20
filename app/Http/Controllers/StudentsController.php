<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRequest;
use App\Models\ClassSchool;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type == User::TYPE_PARENT) {
            return Student::with('parent', 'class', 'grades', 'grades.task')->where('parent_id', Auth::user()->id)->get();
        }
        return Student::with('parent', 'class', 'grades', 'grades.task')->get();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StudentRequest $request)
    {
        if (Auth::user()->type == User::TYPE_PARENT) {
            if ($request->has('photo_src')) {
                $image_64 = $request->input('photo_src');

                $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
                $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
                $image = str_replace($replace, '', $image_64);
                $image = str_replace(' ', '+', $image);
                $imageName = md5($image_64) . '.' . $extension;

                Storage::disk('public')->put($imageName, base64_decode($image));
            }
            return Student::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'class_id' => $request->class_id,
                'photo' => $request->photo,
                'parent_id' => Auth::user()->id
            ])->load('parent', 'class');
        }
        return abort(401);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Student $student
     * @return Student
     */
    public function update(StudentRequest $request, Student $student)
    {

        if ($request->has('photo_src')) {
            $image_64 = $request->input('photo_src');

            $extension = explode('/', explode(':', substr($image_64, 0, strpos($image_64, ';')))[1])[1];
            $replace = substr($image_64, 0, strpos($image_64, ',') + 1);
            $image = str_replace($replace, '', $image_64);
            $image = str_replace(' ', '+', $image);
            $imageName = md5($image_64) . '.' . $extension;

            Storage::disk('public')->put($imageName, base64_decode($image));
        }
        $newStudent = $student->fill([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'class_id' => $request->class_id,
            'photo' => isset($imageName) ? '/storage/' . $imageName : null
        ])->load('parent', 'class', 'grades', 'grades.task');

        if ($newStudent->save()) {
            return $newStudent;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Student $students
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        return $student->delete();
    }
}
