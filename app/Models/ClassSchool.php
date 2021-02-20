<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchool extends Model
{
    use HasFactory;

    protected $table = 'classes';

    public function students() {
        return $this->hasMany(Student::class, 'class_id', 'id');
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
        'parent_id',
    ];


}
