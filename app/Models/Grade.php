<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Grade extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'id');
    }

    public function task()
    {
        return $this->belongsTo(Task::class, 'task_id', 'id');
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'grade',
        'task_id',
        'student_id',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_to' => 'datetime',
    ];
}
