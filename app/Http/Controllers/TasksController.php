<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Models\ClassSchool;
use App\Models\Grade;
use App\Models\Tasks;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->type == User::TYPE_PARENT) {
            return Task::with(['class', 'grades', 'class.students' => function($q)
            {
                $q->where('parent_id', '=', Auth::user()->id);

            }])
            ->whereHas('class.students', function ($query) {
                return $query->where('parent_id', '=', Auth::user()->id);
            })->get();
        }
        return Task::with('class', 'grades', 'class.students')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        if (Auth::user()->type == User::TYPE_TEACHER) {
            return Task::create([
                'name' => $request->name,
                'desc' => $request->desc,
                'class_id' => $request->class_id,
                'date_to' => $request->date_to,
            ])->load('class', 'grades', 'class.students');
        }
        return abort(401);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Tasks $tasks
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return $task->with('class', 'grades', 'class.students')->first();
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Tasks $task
     * @return Tasks
     */
    public function update(TaskRequest $request, Task $task)
    {
        if (Auth::user()->type == User::TYPE_TEACHER) {

            $newTask = $task->fill([
                'name' => $request->name,
                'desc' => $request->desc,
                'class_id' => $request->class_id,
                'date_to' => $request->date_to
            ])->load('class', 'grades', 'class.students');

            if ($newTask->save()) {
                return $newTask;
            }
        }
        return abort(401);
    }

    public function storeGrades(Request $request, Task $task)
    {
        if (Auth::user()->type == User::TYPE_TEACHER) {

            foreach ($request->input('students') as $student) {
                return Grade::updateOrCreate([
                    'task_id' => $task->id,
                    'student_id' => $student['id']
                ],
                    ['grade' => $student['grade']['grade']
                    ]);
            }
        }
        return abort(401);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Tasks $tasks
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tasks $task)
    {
        if (Auth::user()->type == User::TYPE_TEACHER) {

            return $task->delete();
        }
        return abort(401);
    }
}
