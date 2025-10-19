<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['title','description','price'];
    public function classes() { return $this->hasMany(ClassModel::class, 'course_id'); }
}
