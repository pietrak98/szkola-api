<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Task extends Model
{
    use HasFactory, Notifiable, HasApiTokens;

    public function class()
    {
        return $this->belongsTo(ClassSchool::class, 'class_id', 'id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'task_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'desc',
        'date_to',
        'class_id'
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
