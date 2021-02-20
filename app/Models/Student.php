<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id', 'id');
    }

    public function class()
    {
        return $this->belongsTo(ClassSchool::class, 'class_id', 'id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'student_id', 'id');
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'class_id',
        'photo',
        'parent_id'
    ];
}
