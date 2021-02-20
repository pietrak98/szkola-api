<?php

use App\Http\Controllers\ClassesController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\TasksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware(['auth:api'])->group(function () {
    Route::get('/token/revoke', function (Request $request) {
        DB::table('oauth_access_tokens')
            ->where('user_id', $request->user()->id)
            ->update([
                'revoked' => true
            ]);
        return response()->json('DONE');
    });

    Route::get('/active_user', function (Request $request) {
        return response()->json(request()->user());
    });

    Route::get('/classes', [ClassesController::class, 'index']);

    Route::get('/students', [StudentsController::class, 'index']);
    Route::post('/students', [StudentsController::class, 'store']);
    Route::put('/students/{student}', [StudentsController::class, 'update']);
    Route::delete('/students/{student}', [StudentsController::class, 'destroy']);

    Route::get('/tasks', [TasksController::class, 'index']);
    Route::get('/tasks/{task}', [TasksController::class, 'show']);
    Route::post('/tasks', [TasksController::class, 'store']);
    Route::put('/tasks/{task}', [TasksController::class, 'update']);
    Route::delete('/tasks/{task}', [TasksController::class, 'destroy']);

    Route::put('/tasks/{task}/grades', [TasksController::class, 'storeGrades']);

    Route::get('/messages', [MessagesController::class, 'index']);
    Route::get('/messages/{message}', [MessagesController::class, 'show']);

    Route::put('/messages/{message}/setread', [MessagesController::class, 'setRead']);


});
