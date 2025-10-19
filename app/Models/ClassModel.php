<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassModel extends Model
{
    protected $table = 'classes';
    protected $fillable = ['course_id','tutor_id','name','capacity','start_date','end_date'];
    public function course() { return $this->belongsTo(Course::class); }
    public function tutor() { return $this->belongsTo(User::class, 'tutor_id'); }
    public function enrollments() { return $this->hasMany(Enrollment::class); }
}
